<?php

namespace App\Http\Controllers;

use App\Events\TaskCreated;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;

    class BroadcastController extends Controller
    {

        public function authenticate(Request $request)

        {

            $this->authorize('broadcast', $request->user());


            return Broadcast::auth($request);

        }

    }
