<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view roles', only: ['index']),
            new Middleware('permission:edit roles', only: ['edit']),
            new Middleware('permission:create roles', only: ['create']),
            new Middleware('permission:delete roles', only: ['destroy']),
        ];
    }

    /**
     * This method will show permission page
     */
    public function index() {
        $roles = Role::orderBy('name', 'ASC')->paginate(25);
        return view('roles.show', [
            'roles' => $roles,
        ]);
    }

    /**
     * This method will show create permission page
     */
    public function create() {
        $permissions = Permission::orderBy('name', 'ASC')->get();

        // Mengelompokkan permissions berdasarkan kategori
        $groupedPermissions = $permissions->groupBy(function ($permission) {
            if (str_contains($permission->name, 'articles')) return 'Articles';
            if (str_contains($permission->name, 'permissions')) return 'Permissions';
            if (str_contains($permission->name, 'roles')) return 'Roles';
            if (str_contains($permission->name, 'users')) return 'Users';
            return 'Others';
        });

        return view('roles.create', [
            'permissions' => $permissions,
            'groupedPermissions' => $groupedPermissions,
        ]); 
    }

    /**
     * This method will insert a permission
     */
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            "name" => 'required|unique:roles|min:3',
        ]);

        if ($validator->passes()){
            $role = Role::create(['name' => $request->name]);

            if (!empty($request->permission)) {
                foreach ($request->permission as $name) {
                    $role->givePermissionTo($name);
                }
            }

            return redirect()->route('roles.index')->with('success', 'Role added successfully.');
        } else {
            return redirect()->route('roles.create')->withInput()->withErrors($validator);
        }
    }

    /**
     * This method will show edit permission page
     */
    public function edit($id) {
        $role = Role::findOrFail($id);
        $hasPermissions = $role->permissions->pluck('name');
        $permissions = Permission::orderBy('name', 'ASC')->get();

        // Mengelompokkan permissions berdasarkan kategori
        $groupedPermissions = $permissions->groupBy(function ($permission) {
            if (str_contains($permission->name, 'articles')) return 'Articles';
            if (str_contains($permission->name, 'permissions')) return 'Permissions';
            if (str_contains($permission->name, 'roles')) return 'Roles';
            if (str_contains($permission->name, 'users')) return 'Users';
            return 'Others';
        });

        return view('roles.edit', [
            'groupedPermissions' => $groupedPermissions,
            'permissions' => $permissions,
            'hasPermissions' => $hasPermissions,
            'role' => $role,
        ]);
    }

    /**
     * This method will update a permission
     */
    public function update(Request $request, $id) {
        $role = Role::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,' .$id. ',id',
        ]);

        if ($validator->passes()){
            $role->name = $request->name;
            $role->save();

            if (!empty($request->permission)) {
                $role->syncPermissions($request->permission);
            } else {
                // $role->syncPermissions([]);
            }

            return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
        } else {
            return redirect()->route('roles.edit', $id)->withInput()->withErrors($validator);
        }
    }

    /**
     * This method will delete a permission
     */
    public function destroy(Request $request) {
        $id = $request->id;
        $role = Role::find($id);

        if ($role == null) {
            session()->flash('error', 'Role not found.');
            return response()->json([
                'status' => false,
            ]);
        }

        $role->delete();
        session()->flash('success', 'Role deleted successfully.');
        return response()->json([
            'status' => true,
        ]);
    }
}
