<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProgramRequest;
use App\Http\Requests\UpdateProgramRequest;
use App\Models\Program;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProgramController extends Controller
{
    /**
     * Display a listing of the programs.
     */
    public function index()
    {
        $programs = Program::latest()->paginate(20);
        
        return Inertia::render('admin/programs/index', [
            'programs' => $programs
        ]);
    }

    /**
     * Show the form for creating a new program.
     */
    public function create()
    {
        return Inertia::render('admin/programs/create');
    }

    /**
     * Store a newly created program.
     */
    public function store(StoreProgramRequest $request)
    {
        $program = Program::create($request->validated());

        return redirect()->route('programs.show', $program)
            ->with('success', 'Program created successfully.');
    }

    /**
     * Display the specified program.
     */
    public function show(Program $program)
    {
        $program->load(['affiliateLinks.user', 'sales.affiliate']);
        
        return Inertia::render('admin/programs/show', [
            'program' => $program
        ]);
    }

    /**
     * Show the form for editing the specified program.
     */
    public function edit(Program $program)
    {
        return Inertia::render('admin/programs/edit', [
            'program' => $program
        ]);
    }

    /**
     * Update the specified program.
     */
    public function update(UpdateProgramRequest $request, Program $program)
    {
        $program->update($request->validated());

        return redirect()->route('programs.show', $program)
            ->with('success', 'Program updated successfully.');
    }

    /**
     * Remove the specified program.
     */
    public function destroy(Program $program)
    {
        $program->delete();

        return redirect()->route('programs.index')
            ->with('success', 'Program deleted successfully.');
    }
}