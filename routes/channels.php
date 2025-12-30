<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    // هذا يتحقق أن المستخدم الذي يستمع هو نفسه صاحب الـ id
    return (int) $user->id === (int) $id;
});