public function createAdminUser(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required|confirmed|min:8'
    ]);

    $userClass = \App\Models\User::class;
    $user = $userClass::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => \Illuminate\Support\Facades\Hash::make($request->password)
    ]);

    // Asignar rol admin
    $user->assignRole('admin');

    return redirect()->route('install.finish');
}

