<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LearningMaterial extends Model {

	protected $table = 'learning_materials';

	protected $fillable = [
		'url', 
		'description'
	];

	//eloquent relationship
	public function learning_topic() {
        return $this->belongsTo(LearningTopic::class);
    }
    
}
