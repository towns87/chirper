<?php

namespace App\Http\Controllers;
use Illuminate\Http\RedirectResponse;
use App\Models\Chirp;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use App\Models\Tag;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('chirps.index', [
            'chirps' => Chirp::with('user')->latest()->get(),
        ]);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('chirps/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
    

        // logic to handle chirp tags

        $validated = $request->validate([
            'message' => 'required|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            
        ]);

        

        $chirp = $request->user()->chirps()->create([
            'message' => $validated['message'],
            'user_id' => auth()->id(),
        ]);

        if (!empty($validated['tags'])) {
            $tags = collect($validated['tags'])->map(function($tag){
                return Tag::firstOrCreate(['name' => $tag]);
            });
            $chirp->tags()->sync($tags->pluck('id'));
        }
        return redirect()->route('chirps.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp): View
    {
        Gate::authorize('update' , $chirp);

        return view('chirps.edit', [
            'chirp' => $chirp,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp): RedirectResponse
    {
        Gate::authorize('update', $chirp);
 
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);
 
        $chirp->update($validated);
 
        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp): RedirectResponse
    {
        Gate::authorize('delete', $chirp);

        $chirp->delete();

        return redirect(route('chirps.index'));
    }

    
}
