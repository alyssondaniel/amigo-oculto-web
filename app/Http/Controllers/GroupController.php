<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use App\Traits\DrawLotsTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class GroupController extends Controller
{
    use DrawLotsTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Group::withTrashed()->where('user_id', Auth::id())->get();
        return Inertia::render('Group/Index', ['groups' => $groups]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Group/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Nome é obrigatório!',
        ]);

        $gift = new Group($request->all());
        $gift->user_id = Auth::id();
        $gift->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        $group = Group::query()->ownerOrInviteGroup()->find($group->id);
        $users = $group->userGroups()->orderBy('name')->get();

        return Inertia::render('Group/Show', ['group' => $group ?? [], 'users' => $users]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        return Inertia::render('Group/Create', ['group' => $group, 'isUpdating' => true]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Nome é obrigatório!',
        ]);

        $group->update($request->all());
        return redirect()->route('groups.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        $group->delete();
        return redirect()->back();
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(string $id)
    {
        Group::withTrashed()->find($id)->restore();
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function invite(Request $request, Group $group)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ], [
            'email.required' => 'E-mail é obrigatório!',
            'email.email' => 'E-mail não é valido!'
        ]);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        $user = User::where('email', $request->email)->first();
        if (empty($user)) {
            $validator->errors()->add('email', 'E-mail não encontrado');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $groupUsers = $user->groupUsers()->where('group_users.group_id', $group->id)->first();
        if ($groupUsers) {
            $validator->errors()->add('email', 'Convite já foi enviado!');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user->groupUsers()->attach([$group->id]);
        return redirect()->back();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function acceptInvite(Request $request, string $groupId)
    {

        $user = User::find(Auth::id());
        $user->groupUsers()
            ->syncWithPivotValues([$groupId], ['accepted_invite' => true]);

        return redirect()->back();
    }

    public function runDrawLots(Request $request, Group $group)
    {
        $drawLots = self::drawLots($group);
        $group = Group::query()->ownerOrInviteGroup()->find($group->id);
        $users = $group->userGroups()->orderBy('name')->get();

        return Inertia::render('Group/Show', ['group' => $group ?? [], 'users' => $users, 'drawLots' => $drawLots]);
    }
}
