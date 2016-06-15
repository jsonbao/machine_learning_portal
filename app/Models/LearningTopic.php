<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LearningTopic extends Model {
    
    protected $table = 'learning_topics';

	protected $fillable = [
		'name', 
		'description'
	];

	//eloquent relationships
	public function materials() {
        return $this->hasMany(LearningMaterial::class);
    }

	public function problems() {
        return $this->hasMany(Problem::class);
    }

    public function subjects() {
    	return $this->belongsToMany(Subject::class, 'learning_topic_subject', 'learning_topic_id', 'subject_id');
    }

}
