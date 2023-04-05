<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;


class UsersExport implements FromCollection, WithHeadings
{
    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function collection()
    {
        return $this->users;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Username',
            'Roles',
            'Email Verified At',
            'Phone',
            'Password',
            'Two Factor Secret',
            'Two Factor Recovery Codes',
            'Remember Token',
            'Current Team ID',
            'Profile Photo Path',
            'Created At',
            'Updated At',
        ];
    }
}
