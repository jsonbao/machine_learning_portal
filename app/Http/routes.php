<?php

Route::group(['middleware' => 'web'], function() {
	
	//learning topic routes
	Route::group(['prefix' => 'api/topic'], function () {
		
		Route::get('/', 'LearningTopicController@GetAllTopics');
		
		Route::get('/{id}', 'LearningTopicController@GetTopicById');
		
		Route::post('/', 'LearningTopicController@AddNewTopic');

		Route::post('/{id}/subject/add', 'LearningTopicController@AddSubjectsToTopic');
		
		Route::post('/{id}/subject/remove', 'LearningTopicController@RemoveSubjectsFromTopic');

		Route::delete('/{id}', 'LearningTopicController@DeleteTopic');

	});

	//subject routes
	Route::group(['prefix' => 'api/subject'], function () {
		
		Route::get('/', 'SubjectController@GetAllSubjects');

		Route::get('/{id}', 'SubjectController@GetSubjectById');

		Route::post('/', 'SubjectController@AddNewSubject');

		Route::post('/{id}/topic/add', 'SubjectController@AddTopicsToSubject');
		
		Route::post('/{id}/topic/remove', 'SubjectController@RemoveTopicsFromSubject');

		Route::delete('/{id}', 'SubjectController@DeleteSubject');

	});

	//learning material routes
	Route::group(['prefix' => 'api/material'], function () {
		
		Route::get('/', 'LearningMaterialController@GetAllLearningMaterials');

		Route::get('/{id}', 'LearningMaterialController@GetLearningMaterialById');

		Route::get('/topic/{id}', 'LearningMaterialController@GetAllLearningMaterialsForTopic');

		Route::post('/', 'LearningMaterialController@AddNewLearningMaterial');
		
		Route::delete('/{id}', 'LearningMaterialController@DeleteLearningMaterial');
	});

	//problem routes
	Route::group(['prefix' => 'api/problem'], function () {

		Route::get('/', 'ProblemController@GetAllProblems');

		Route::get('/{id}', 'ProblemController@GetProblemById');

		Route::get('/topic/{id}', 'ProblemController@GetAllProblemsForTopic');

		Route::post('/', 'ProblemController@AddNewProblem');
		
		Route::delete('/{id}', 'ProblemController@DeleteProblem');
		
	});

});

