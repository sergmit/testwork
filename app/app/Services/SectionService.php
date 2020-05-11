<?php


namespace App\Services;

use App\Http\Resources\SectionCollection;
use App\Models\Section;
use App\Models\UserSection;
use App\User;
use Exception;
use Illuminate\Support\Facades\DB;

class SectionService
{
    public const COUNT_SECTIONS_PAGE = 10;

    /**
     * Get Sections
     *
     * @return SectionCollection
     */
    public function getSections(): SectionCollection
    {
        $sections = Section::with('users')->paginate(self::COUNT_SECTIONS_PAGE);

        return new SectionCollection($sections);
    }

    /**
     * Create section
     *
     * @param $data
     */
    public function createSection($data): void
    {
        DB::transaction(function () use ($data) {
            $pathImage = $data['logo']->store('logo');
            $section = new Section();
            $section->name = $data['name'];
            $section->description = $data['description'];
            $section->logo = asset($pathImage);
            $section->save();
            $section->users()->sync($data['users']);
            $section->save();
        });
    }

    /**
     * Update section
     *
     * @param Section $section
     * @param $data
     * @return Section
     */
    public function updateSection(Section $section, $data): Section
    {
        $pathImage = $data['logo']->store('logo');
        $section->name = $data['name'];
        $section->description = $data['description'];
        $section->logo = asset($pathImage);

        if (!empty($data['users'])) {
            $section->users()->sync($data['users']);
        }

        $section->save();
        $section->load('users');

        return $section;
    }

    /**
     * Section delete
     *
     * @param Section $section
     * @throws Exception
     */
    public function destroySection(Section $section): void
    {
        $section->delete();
    }
}
