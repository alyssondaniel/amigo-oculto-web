<?php

namespace App\Http\Controllers;

use App\Models\Gift;
use App\Models\Group;
use App\Traits\DrawLotsTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Group::query()->ownerOrInviteGroup()->get();

        return Inertia::render('Dashboard', ['groups' => $groups]);
    }
}
