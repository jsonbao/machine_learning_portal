<?php

Route::group(['middleware' => 'web'], function() {
	
	//learning topic routes
	Route::group(['prefix' => 'api/topic'], function () {
		
		Route::get('/', 'LearningTopicController@GetAllTopics');
		
		Route::get('/{id}', 'LearningTopicController@GetTopicById');
		
		Route::post('/', 'LearningTopicController@AddNewTopic');

		Route::post('/{id}/subjects/add', 'LearningTopicController@AddSubjectsToTopic');
		
		Route::post('/{id}/subjects/remove', 'LearningTopicController@RemoveSubjectsFromTopic');

		Route::delete('/{id}', 'LearningTopicController@DeleteTopic');

	});

});

