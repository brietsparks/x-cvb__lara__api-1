<?php

namespace App\Models\Services;

use App\Models\Skill;

class SkillService
{

    /**
     * @param array $skillData
     * @param int $user_id
     * @return Skill
     */
    public function createSkill(array $skillData, $user_id)
    {
        $skillData['creator_id'] = $user_id;
        $skill = Skill::create($skillData);

        return $skill;
    }

    /**
     * @param array $skillData
     * @param int $user_id
     * @return Skill
     */
    public function resolveSkillByTitle(array $skillData, $user_id)
    {
        $title = $skillData['title'];

        if ($skill = $this->getSkillByTitle($title)) {
            return $skill;
        } else {
            return $this->createSkill($skillData, $user_id);
        }
    }

    /**
     * @param $id
     * @return Skill
     */
    public function getSkillById($id)
    {
        return Skill::find($id);
    }

    /**
     * @param $title
     * @return Skill
     */
    public function getSkillByTitle($title)
    {
        return Skill::whereTitle($title)->first();
    }

    /**
     * @param int $id
     * @param array $skillData
     * @return Skill
     */
    public function updateSkill($id, array $skillData)
    {
        $skill = Skill::find($id);
        $skill->title = $skillData['title'];
        $skill->update();

        return $skill;
    }

    /**
     * @param int $id
     * @return boolean
     */
    public function deleteSkill($id)
    {
        $skill = Skill::find($id);

        // todo: event skill deleted
        return $skill->delete();
    }
}