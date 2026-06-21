<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faculty extends Model
{
    /** @use HasFactory<\Database\Factories\FacultyFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'institution_id',
        'country_id',
        'dean_id',
    ];

    public static array $faculties = [
        'Biological Engineering',
        'Human Resources Management',
        'Computer Science',
        'Mechanical Engineering',
        'Electrical Engineering',
        'Architecture',
        'Medicine',
        'Law',
        'Economics',
        'Psychology',
        'Chemistry',
        'Physics',
        'Mathematics',
        'Biology',
        'Geology',
        'History',
        'Philosophy',
        'Literature',
        'Linguistics',
        'Sociology',
        'Political Science',
        'Art History',
        'Music',
        'Theater Studies',
        'Education',
        'Sports Science',
        'Nutrition',
        'Environmental Science',
        'Agricultural Sciences',
        'Veterinary Medicine',
        'Dental Medicine',
        'Pharmacy',
        'Public Health',
        'Nursing',
        'Biomedical Engineering',
        'Aerospace Engineering',
        'Automotive Engineering',
        'Civil Engineering',
        'Energy Resources',
        'Materials Science',
        'Nanotechnology',
        'Robotics',
        'Artificial Intelligence',
        'Cybersecurity',
        'Data Science',
        'Web Technologies',
        'Game Development',
        'Animation',
        'Design',
        'Fashion',
        'Journalism',
        'Marketing',
        'Finance',
        'Accounting',
        'Management',
        'Entrepreneurship',
        'Logistics',
        'Transportation',
        'Tourism',
        'Hospitality',
        'Culinary Arts',
        'Social Work',
        'Clinical Psychology',
        'Counseling',
        'Theology',
        'Religious Studies',
        'International Relations',
        'Diplomacy',
        'Public Administration',
        'Library Science',
        'Archival Studies',
        'Museology',
        'Conservation',
        'Renewable Energy',
        'Sustainable Development',
        'Urban Planning',
        'Geography',
        'Meteorology',
        'Oceanography',
        'Astronomy',
        'Nuclear Physics',
        'Quantum Physics',
        'Biochemistry',
        'Genetics',
        'Microbiology',
        'Immunology',
        'Neuroscience',
    ];

    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function dean(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dean_id');
    }
}
