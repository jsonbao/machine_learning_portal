<?php

namespace App\Dal;

use App\Dal\Interfaces\ILearningMaterialDal;

use App\Models\LearningTopic as LearningTopic;

use App\Models\LearningMaterial as LearningMaterial;

class LearningMaterialDal implements ILearningMaterialDal {

    public function GetAllLearningMaterials() {
        return LearningMaterial::all();
    }

    public function GetLearningMaterialById($id) {
        return LearningMaterial::where('id', $id)->get();
    }
    
    public function GetAllLearningMaterialsForTopic($topicId) {
        return learningMaterial::where('learning_topic_id', $topicId)->get();
    }
    
    public function AddNewLearningMaterial($topicId, LearningMaterial $learningMaterial) {
        $topic = LearningTopic::find($topicId);

        return $topic->materials()->create([
            'url' => $learningMaterial->url,
            'description' => $learningMaterial->description
        ]);
    }
    
    public function DeleteLearningMaterial($id) {
        LearningMaterial::destroy($id);
    }


}
