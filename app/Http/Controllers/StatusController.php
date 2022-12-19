<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStatusRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Models\Status;
use App\Models\User;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuses = auth()->user()->statuses()
            ->with('user', 'user.lastStatus')
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
        return view('users.statuses.index', compact('statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Status::class);
        return view('users.statuses.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStatusRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStatusRequest $request)
    {
        $validated = $request->validated();
        $status = auth()->user()->statuses()->create([
            'body' => $validated['body'],
        ]);
        return redirect(route('users.show', auth()->user()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function show(Status $status)
    {
        $this->authorize('view', $status);
        return view('users.statuses.show', compact('status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function edit(Status $status)
    {
        $this->authorize('update', $status);
        return view('users.statuses.edit', compact('status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStatusRequest  $request
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStatusRequest $request, Status $status)
    {
        $validated = $request->validated();
        $status->update([
            'body' => $validated['body'],
        ]);
        return redirect(route('users.show', auth()->user()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function destroy(Status $status)
    {
        $this->authorize('delete', $status);
        $status->delete();
        return redirect(route('users.show', auth()->user()));
    }
}
