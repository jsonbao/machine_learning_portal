<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model {

     protected $table = 'subjects';

	protected $fillable = [
		'name'
	];

	//eloquent relationship
	//remainder: we use attach() and detach() methods for adding or deleting items.
	public function learning_topics() {
    	return $this->belongsToMany(LearningTopic::class, 'learning_topic_subject', 'learning_topic_id', 'subject_id');
    }

}
