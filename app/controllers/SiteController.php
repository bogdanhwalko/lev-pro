<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\forms\ContactForm;
use app\models\LoginForm;
use app\models\Project;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        //Yii::$app->session->set('mode', 'dev');
//        if (Yii::$app->session->get('mode', 'user') !== 'dev') {
//            echo '<center><h1>The site is under development!</h1></center>'; exit();
//        }

        return $this->render('index');
    }


    public function actionLogin(): Response|string
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['/admin']);
        }

        $this->layout = '/login-layout';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['/admin']);
        }

        return $this->render('login', ['model' => $model]);
    }

    public function actionSitemap(): Response
    {
        $siteUrl    = rtrim(Yii::$app->params['siteUrl'], '/');
        $categories = Yii::$app->params['gallery-folder'];
        $today      = date('Y-m-d');

        $urls = [
            ['loc' => $siteUrl . '/',        'lastmod' => $today, 'changefreq' => 'weekly',  'priority' => '1.0'],
            ['loc' => $siteUrl . '/contact', 'lastmod' => $today, 'changefreq' => 'monthly', 'priority' => '0.8'],
        ];

        foreach ($categories as $category) {
            $lastProject = Project::find()
                ->where(['category' => $category])
                ->orderBy(['updated_at' => SORT_DESC])
                ->one();

            $urls[] = [
                'loc'        => $siteUrl . '/gallery/' . $category,
                'lastmod'    => $lastProject ? date('Y-m-d', $lastProject->updated_at) : $today,
                'changefreq' => 'weekly',
                'priority'   => '0.9',
            ];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n"
             . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $url) {
            $xml .= "  <url>\n"
                  . '    <loc>'        . htmlspecialchars($url['loc'], ENT_XML1) . "</loc>\n"
                  . '    <lastmod>'    . $url['lastmod']    . "</lastmod>\n"
                  . '    <changefreq>' . $url['changefreq'] . "</changefreq>\n"
                  . '    <priority>'   . $url['priority']   . "</priority>\n"
                  . "  </url>\n";
        }

        $xml .= '</urlset>';

        $response = Yii::$app->response;
        $response->format = Response::FORMAT_RAW;
        $response->headers->set('Content-Type', 'application/xml; charset=utf-8');
        $response->content = $xml;

        return $response;
    }

    public function actionLogout(): Response
    {
        Yii::$app->user->logout();
        return $this->redirect(['/']);
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->contact()) {
                Yii::$app->session->setFlash('contactFormSubmitted');
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }
}
