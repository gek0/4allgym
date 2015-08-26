<?php

class PublicController extends BaseController
{

    /**
     * CSRF validation on requests
     */
    public function __construct()
    {
        $this->beforeFilter('crfs', ['on' => ['post', 'put', 'patch', 'delete']]);

        //closure as callback
        $this->beforeFilter(function(){
            $this->cacheCheck();
        });
    }

    /**
     * show homepage
     * @return mixed
     */
    public function showHome()
    {
        return View::make('public.index')->with(['page_title' => 'Početna']);
    }

    /**
     * show contact page
     * @return mixed
     */
    public function showContact()
    {
        return View::make('public.kontakt')->with(['page_title' => 'Kontakt']);
    }

    /**
     * send email from contact form over Ajax request
     * @return mixed
     */
    public function sendMail()
    {
        if (Request::ajax()) {

            //define validator rules and messages
            $rules = ['full_name' => 'required|between:2,100',
                        'email' => 'required|email',
                        'subject' => 'required|between:2,100',
                        'message_body' => 'required|min:10',
                        'g-recaptcha-response' => 'required|captcha'
                    ];

            $messages = ['full_name.required' => 'Zaboravili ste unjeti ime i prezime.',
                            'full_name.between' => 'Ime i prezime ne mogu biti dulji od 100 znakova i kraći od 2.',
                            'email.required' => 'E-mail adresa je obavezno polje.',
                            'email.email' => 'Unjeta e-mail adresa nije važeća.',
                            'subject.required' => 'Zaboravili ste unjeti naslov poruke.',
                            'subject.between' => 'Naslov poruke ne može biti dulji od 100 znakova i kraći od 2.',
                            'message_body.required' => 'Poruka je obavezno polje.',
                            'message_body.min' => 'Poruka je prekratka, minimalno 10 znakova.',
                            'g-recaptcha-response.required' => 'Captcha je obavezna.',
                            'g-recaptcha-response.captcha' => 'Captcha nije važeća.'
                        ];

            //get form data
            $input_data = Input::get('formData');
            $token = Input::get('_token');
            $user_data = ['full_name' => e($input_data['full_name']),
                            'email' => e($input_data['email']),
                            'subject' => e($input_data['subject']),
                            'message_body' => e($input_data['message_body']),
                            'g-recaptcha-response' => e($input_data['g-recaptcha-response'])
                        ];

            //validate user data
            $validator = Validator::make($user_data, $rules, $messages);

            //check if csrf token is valid
            if(Session::token() != $token){
                return Response::json(['status' => 'error',
                                        'errors' => 'CSRF token is not valid.'
                                    ]);
            }
            else {
                //check validation results and save user if ok
                if($validator->fails()){
                    return Response::json(['status' => 'error',
                                            'errors' => $validator->getMessageBag()->toArray()
                                        ]);
                }
                else{
                    //send email
                    try{
                        Mail::send('email', $user_data, function($message) use ($user_data){
                                    $message->from($user_data['email'], $user_data['full_name']);
                                    $message->to(getenv('OWNER_CONTACT_EMAIL'))->subject('4allGym web - nova poruka');
                                });

                        return Response::json(['status' => 'success']);
                    }
                    catch(Exception $e){
                        return Response::json(['status' => 'error',
                                                'errors' => 'E-mail nije mogao biti poslan.'
                                            ]);
                    }
                }
            }
        }
        else{
            return Response::json(['status' => 'error',
                                    'errors' => 'Data not sent with Ajax.'
                                ]);
        }
    }

    /**
     * show about us/info  page
     * @return mixed
     */
    public function showAboutUs()
    {
        return View::make('public.onama')->with(['page_title' => 'O nama']);
    }

    /**
     * show all news tags
     * @return mixed
     */
    public function showTags()
    {
        $tags_data = Tag::all();

        return View::make('public.tagovi')->with(['tags_data' => $tags_data,
                                                    'page_title' => 'Tagovi'
                                                ]);
    }

    public function getRss()
    {
        //generate feed and cache for 60 min
        $feed = Feed::make();
        $feed->setCache(60, '4allGymRssKey');

        //check if there is cached version
        if(!$feed->isCached()) {
            //grab news data from database
            $news_data = News::orderBy('id', 'DESC')->take(5)->get();

            //check if there are news
            if ($news_data == true) {
                //set feed parameters
                $feed->title = '4allGym RSS';
                $feed->description = 'Najnovije vijesti na 4allGym portalu';
                $feed->logo = URL::to('css/assets/images/logo_nav.png');
                $feed->link = URL::to('rss');
                $feed->setDateFormat('datetime');
                $feed->pubdate = $news_data[0]->created_at;
                $feed->lang = 'hr';
                $feed->setShortening(true);
                $feed->setTextLimit(500);

                foreach ($news_data as $news) {
                    $feed->add($news->news_title, $news->author->username, URL::to('portal/pregled/' . $news->slug), $news->created_at, (new BBCParser)->unparse($news->news_body), '');
                }
            }
            else{
                return Redirect::to('portal')->withErrors('Trenutno nema vijesti. RSS je isključen.');
            }
        }

        return $feed->render('atom');
    }

}