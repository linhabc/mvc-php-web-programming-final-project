<?php
namespace App\Models;

abstract class Role
{
    const Admin = 0;
    const User = 1;
}

// use: $role = Role::Admin;