<?php

namespace App\Enums;

enum Permissions {
    case is_admin;
    case is_teacher;
    case is_student;

    // case create_grades   ;
    // case edit_grades     ;
    // case delete_grades   ;
    // case see_grades      ;
    // case create_courses  ;
    // case edit_courses    ;
    // case delete_courses  ;
    // case see_courses     ;
    // case approve_enrolls ;
    // case enroll_courses  ;
    // case dropping_courses;
    // case create_users    ;
    // case edit_users      ;
    // case delete_users    ;
    // case see_users       ;
    // case edit_role       ;
} 