<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAvatarRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    public function update(UpdateAvatarRequest $request) 
    {
        $path = Storage::disk('public_uploads')->put('images/avatars', $request->file('avatar'));
        // $path = $request->file('avatar')->store('images/avatars', ['disk' => "public_uploads"]);
        $oldAvatar = $request->user()->avatar;
        if ($oldAvatar) {
            Storage::disk('public_uploads')->delete($oldAvatar);
        }

        auth()->user()->update(['avatar' => $path]);
        return redirect(route('profile.edit'))->with('msg', 'Avatar is updated successfully');
    }
}
