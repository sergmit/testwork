<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionRequest;
use App\Models\Section;
use App\Services\SectionService;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;

class SectionController extends Controller
{
    protected $sectionService;

    /**
     * SectionController constructor.
     *
     * @param SectionService $sectionService
     */
    public function __construct(SectionService $sectionService)
    {
        $this->sectionService = $sectionService;
    }

    /**
     * Section page
     *
     * @return Renderable
     */
    public function page(): Renderable
    {
        return view('sections.index');
    }

    /**
     * Get Sections list
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $sections = $this->sectionService->getSections();

        return response()->json($sections);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SectionRequest $request
     * @return JsonResponse
     */
    public function store(SectionRequest $request): JsonResponse
    {
        $this->sectionService->createSection($request->all());

        return response()->json();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Section $section
     * @param SectionRequest $request
     * @return JsonResponse
     */
    public function update(Section $section, SectionRequest $request): JsonResponse
    {
        $section = $this->sectionService->updateSection($section, $request->all());

        return response()->json(['section' => $section]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Section $section
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Section $section): JsonResponse
    {
        $this->sectionService->destroySection($section);

        return response()->json(null, 204);
    }
}
