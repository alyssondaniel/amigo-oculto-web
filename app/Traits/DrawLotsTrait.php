<?php

namespace App\Traits;

use App\Models\Group;
use App\Models\User;

trait DrawLotsTrait
{
    public $participants = [];
    private $finalList = [];
    private $chosenOrLastSeleted = null;

    function drawLots(Group $group)
    {
        $this->participants = $group->userGroups()->pluck('name')->toArray();
        $firstSelected = '';
        while (count($this->participants)) {
            if ($this->chosenOrLastSeleted) {
                $selectedToChoose = $this->chosenOrLastSeleted;
            } else {
                $selectedToChoose = self::selectedToChoose();
                $firstSelected = $selectedToChoose;
            }

            $this->chosenOrLastSeleted = self::selectedToChoose();
            self::mergeToFinalList($selectedToChoose, $this->chosenOrLastSeleted);

            if (empty($this->participants))
                self::mergeToFinalList($this->chosenOrLastSeleted, $firstSelected);
        }
        return $this->finalList;
    }

    private function selectedToChoose()
    {
        $key = array_rand($this->participants);
        return array_splice($this->participants, $key, 1)[0];
    }

    private function mergeToFinalList($selectedToChoose, $firstSelected)
    {
        $this->finalList = array_merge($this->finalList, [$selectedToChoose => $firstSelected]);
    }
}
