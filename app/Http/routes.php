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

});

