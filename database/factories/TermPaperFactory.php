<?php

namespace Database\Factories;

use App\Enums\TermPaperStatus;
use App\Enums\UserType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TermPaper>
 */
class TermPaperFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public static array $actions = [
        'Analysis',
        'Modeling',
        'Optimization',
        'Simulation',
        'Prediction',
        'Classification',
        'Detection',
        'Recognition',
        'Estimation',
        'Evaluation',
        'Assessment',
        'Development',
        'Design',
        'Implementation',
        'Integration',
        'Automation',
        'Monitoring',
        'Control',
        'Management',
        'Planning',
        'Forecasting',
        'Characterization',
        'Identification',
        'Verification',
        'Validation',
        'Exploration',
        'Investigation',
        'Examination',
        'Comparative Study',
        'Experimental Analysis',
        'Theoretical Framework',
        'Algorithm Design',
        'Methodology Development',
        'System Architecture',
        'Performance Evaluation',
        'Risk Assessment',
        'Impact Analysis',
        'Feasibility Study',
        'Optimization Strategy',
        'Decision Support',
        'Knowledge Discovery',
        'Pattern Recognition',
        'Anomaly Detection',
        'Trend Analysis',
        'Cost-Benefit Analysis',
        'Lifecycle Assessment',
        'Sustainability Evaluation',
        'Quality Assurance',
        'Process Improvement',
        'Resource Allocation',
        'Strategic Planning',
    ];

    public static array $domains = [
        'Machine Learning',
        'Deep Learning',
        'Neural Networks',
        'Natural Language Processing',
        'Computer Vision',
        'Image Processing',
        'Signal Processing',
        'Big Data Analytics',
        'Data Mining',
        'Web Technologies',
        'Mobile Computing',
        'Cloud Computing',
        'Edge Computing',
        'Internet of Things',
        'Cybersecurity',
        'Network Security',
        'Cryptography',
        'Blockchain Technology',
        'Quantum Computing',
        'Bioinformatics',
        'Computational Biology',
        'Medical Imaging',
        'Healthcare Systems',
        'Biomedical Engineering',
        'Genetic Engineering',
        'Drug Discovery',
        'Clinical Research',
        'Neuroscience',
        'Cognitive Science',
        'Psychology',
        'Human Behavior',
        'Social Networks',
        'Digital Marketing',
        'E-commerce',
        'Financial Technology',
        'Quantitative Finance',
        'Risk Management',
        'Supply Chain Management',
        'Operations Research',
        'Industrial Automation',
        'Robotics',
        'Autonomous Systems',
        'Smart Cities',
        'Urban Planning',
        'Environmental Science',
        'Climate Modeling',
        'Renewable Energy Systems',
        'Energy Efficiency',
        'Sustainable Development',
        'Green Technologies',
        'Waste Management',
        'Circular Economy',
        'Smart Agriculture',
        'Food Technology',
        'Nanotechnology',
        'Materials Science',
        'Aerospace Systems',
        'Automotive Engineering',
        'Marine Biology',
        'Wildlife Conservation',
        'Geospatial Analysis',
        'Remote Sensing',
        'Disaster Management',
        'Public Health',
        'Epidemiology',
        'Pharmacology',
        'Bioethics',
        'Law and Technology',
        'Education Technology',
        'Game Theory',
        'Complex Systems',
        'Data Visualization',
        'Human-Computer Interaction',
        'User Experience',
        'Virtual Reality',
        'Augmented Reality',
        'Digital Humanities',
        'Cultural Heritage',
        'Artificial Intelligence Ethics',
        'Privacy Preservation',
        'Federated Learning',
        'Transfer Learning',
        'Reinforcement Learning',
        'Generative Models',
        'Explainable AI',
        'Graph Neural Networks',
    ];

    public static array $applications = [
        'and Applications',
        'with Applications',
        'and Its Applications',
        'with Real-world Applications',
        'and Practical Applications',
        'and Industrial Applications',
        'and Clinical Applications',
        'with Commercial Applications',
        'and Potential Applications',
        'and Emerging Applications',
        'for Smart Systems',
        'for Autonomous Systems',
        'for Healthcare',
        'for Education',
        'for Business Intelligence',
        'for Decision Support',
        'for Sustainable Development',
        'for Environmental Monitoring',
        'for Cybersecurity',
        'for Social Good',
        'for Financial Services',
        'for E-commerce',
        'for Supply Chain',
        'for Smart Cities',
        'for Precision Agriculture',
        'for Personalized Medicine',
        'for Drug Discovery',
        'for Quality Control',
        'for Process Optimization',
        'for Resource Management',
        'for Disaster Response',
        'for Climate Action',
        'for Energy Efficiency',
        'in Practice',
        'and Case Studies',
        'with Comparative Analysis',
        'and Benchmarking',
        'with Experimental Validation',
        'and Performance Evaluation',
        'and Scalability Analysis',
        'with Security Considerations',
        'and Privacy Implications',
        'for Large-scale Systems',
        'for Real-time Applications',
        'for Distributed Systems',
        'with IoT Integration',
        'and Cloud Computing',
        'in Complex Environments',
        'and Future Perspectives',
        'and Challenges',
        'and Opportunities',
        'in the Digital Age',
        'for Industry 4.0',
        'for Smart Manufacturing',
        'for Precision Agriculture',
    ];

    public function definition(): array
    {
        return [
            'name' => $name = $this->generateThesisName(),
            'slug' => $this->generateThesisSlug($name),
            'teacher_id' => User::ofType(UserType::TEACHER->value)->inRandomOrder()->value('id'),
            'student_id' => User::ofType(UserType::STUDENT->value)->inRandomOrder()->value('id'),
            'start_date' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'end_date' => $this->faker->dateTimeBetween('now', '+6 months'),
            'status' => $this->faker->randomElement(TermPaperStatus::cases()),
            'remark_id' => \App\Models\Remark::inRandomOrder()->value('id'),

        ];
    }

    public function generateThesisName(): string
    {
        $action = $this->faker->randomElement(static::$actions);
        $domain = $this->faker->randomElement(static::$domains);
        if ($this->faker->boolean(60)) {
            return "{$action} of {$domain} {$action}";
        }

        return "{$action} of {$domain}";
    }

    public function generateThesisSlug($name): string
    {
        return Str::slug($name.'_'.$this->faker->uuid());
    }
}
