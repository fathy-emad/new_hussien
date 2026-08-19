<?php

namespace App\Constants;

class Constants
{
    protected string $constant;

    protected array $genders = [
        0 => 'ذكر',
        1 => 'أنثي'
    ];

    protected array $classRooms = [
        1 => 'الصف الأول',
        2 => 'چيولوچيا',
        3 => 'الصف الثالث'
    ];

    protected array $days = [
        1 => 'السبت',
        2 => 'الأحد',
        3 => 'الإثنين',
        4 => 'الثلاثاء',
        5 => 'الأربعاء',
        6 => 'الخميس',
        7 => 'الجمعة'
    ];


    protected array $sectionsIcon = [
        'dashboard' => 'home',
        'settings' => 'settings',
        'permissionsAndEmployees' => 'lock',
        'students' => 'man',
        'website' => 'home',
        'report' => 'report',
        'capacitors' => 'report',
        'exams' => 'report'
    ];

    public function __construct($constant)
    {
        $this->constant = $constant;
    }

    public function getValue($key): string
    {
        return $this->{$this->constant}[$key];
    }

    public function getArray(): array
    {
        return $this->{$this->constant};
    }
}
