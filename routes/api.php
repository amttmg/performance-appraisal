<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
$this->get('users/self', 'UsersController@getLoggedInUser')->middleware('auth');

$this->group(['middleware' => ['roles:supervisor,developer,admin']], function () {

    $this->get('users/select-data', 'UsersController@selectData')->middleware('auth');
    $this->get('users/with-report', 'UsersController@usersWithReport')->middleware('auth');
    $this->get('users/technology/{technologyId}', 'UsersController@usersByTechnology')->middleware('auth');
    $this->get('users/by-role/{role}', 'UsersController@getUserByRole')->middleware('auth');
    $this->post('users/set-new-password/{id?}', 'UsersController@setNewPassword')->middleware('auth');
    $this->get('session', 'SessionController@index');
    $this->patch('session/change-state/{id}', 'SessionController@changeState');
    $this->post('session', 'SessionController@store');
    $this->get('question', 'QuestionController@getAll');
    $this->post('question', 'QuestionController@store');
    $this->patch('question/{id}', 'QuestionController@update');
    $this->delete('question/{id}', 'QuestionController@destroy');
    $this->get('question-group', 'QuestionController@getAllQuestionGroup');
    $this->get('technology', 'QuestionController@getAllQuestionTechnology');
    $this->apiResource('users', 'UsersController');
    $this->post('projects/upload-csv', 'ProjectController@uploadCsv');
    $this->post('projects/link', 'ProjectController@linkProjectsEmployee');
    $this->post('projects/unlink/{id}', 'ProjectController@unLinkProjectEmployee');
    $this->get('projects/get-projects/{technologyId}', 'ProjectController@getUsersWithProjects');
    $this->apiResource('projects', 'ProjectController');


    $this->get('/get-appraise-assigned', 'AppraiseController@getAppraiseAssignToMe');
    $this->post('/appraise/save', 'AppraiseController@store');
    $this->post('/appraise', 'AppraiseController@addAppraise');
    $this->delete('/appraise/{id}', 'AppraiseController@destroy');
    $this->post('/appraise/supervisor', 'AppraiseController@storeSupervisor');
    $this->get('/appraise/report', 'AppraiseController@report');
    $this->get('/appraise/report-all', 'AppraiseController@reportAll');
    $this->post('/appraise/report-upload', 'AppraiseController@reportUpload');
    $this->get('/appraise/report-delete/{id}', 'AppraiseController@reportDelete');
    $this->get('/appraise/', 'AppraiseController@index');
    $this->get('/appraise/reset/{id}', 'AppraiseController@reset');
    $this->get('/get-questions/{appraiseId}', 'AppraiseController@getQuestions');


    $this->post('evaluations/work', 'AppraiseController@importWorkEvaluation');
    $this->post('/evaluations/administrative', 'AppraiseController@importAdministrativeEvaluation');
    $this->get('/evaluations/get', 'AppraiseController@getEvaluations');
});

