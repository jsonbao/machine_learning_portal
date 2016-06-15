<?php

namespace App\Dal\Interfaces;

use App\Models\LearningMaterial as LearningMaterial;

interface ILearningMaterialDal {

	public function GetAllLearningMaterials();

    public function GetLearningMaterialById($id);

	public function GetAllLearningMaterialsForTopic($topicId);
	
	public function AddNewLearningMaterial($topicId, LearningMaterial $learningMaterial);
	
	public function DeleteLearningMaterial($id);

}