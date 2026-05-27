<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index() {
        $groups = Group::withCount('users')->orderBy('label')->get();
        return view('admin.groups.index', compact('groups'));
    }
    public function create() { return view('admin.groups.create'); }
    public function store(Request $request) {
        $request->validate([
            'name'  => 'required|string|max:50|unique:groups,name|alpha_dash',
            'label' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'color' => 'required|string|max:7',
        ]);
        Group::create($request->only('name','label','description','color') + ['active' => $request->boolean('active', true)]);
        return redirect()->route('admin.groups.index')->with('success', 'Grupo criado!');
    }
    public function edit(Group $group) { return view('admin.groups.edit', compact('group')); }
    public function update(Request $request, Group $group) {
        $request->validate([
            'name'  => "required|string|max:50|unique:groups,name,{$group->id}|alpha_dash",
            'label' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'color' => 'required|string|max:7',
        ]);
        $group->update($request->only('name','label','description','color') + ['active' => $request->boolean('active')]);
        return redirect()->route('admin.groups.index')->with('success', 'Grupo atualizado!');
    }
    public function destroy(Group $group) {
        $group->delete();
        return redirect()->route('admin.groups.index')->with('success', 'Grupo removido.');
    }
}
