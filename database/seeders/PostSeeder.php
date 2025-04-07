<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use Carbon\Carbon;

class PostSeeder extends Seeder
{
    public function run()
    {
        $posts = [
            [
                'user_id' => 1,
                'title' => 'Reflecting on Personal Growth This Year',
                'content' => 'Take some time to journal thoughts about personal development, achievements, and lessons learned over the past year. Consider what habits have been most beneficial and what areas still need improvement.',
            ],
            [
                'user_id' => 1,
                'title' => 'Organizing the Digital Workspace',
                'content' => 'Clean up cluttered files on the desktop, organize project folders, delete redundant documents, and back everything up to both the cloud and an external hard drive to ensure security and easy access.',
            ],
            [
                'user_id' => 1,
                'title' => 'Preparing the Presentation for Client Pitch',
                'content' => 'Design a visually compelling PowerPoint presentation that outlines the new proposal’s key points, including objectives, projected outcomes, timelines, and estimated costs. Rehearse delivery for clarity and confidence.',
            ],
            [
                'user_id' => 1,
                'title' => 'Deep Dive Into Advanced Laravel Techniques',
                'content' => 'Block out a few hours to explore advanced Laravel topics such as service containers, custom providers, queues, and broadcasting. Try implementing a real-world example using these concepts to reinforce understanding.',
            ],
            [
                'user_id' => 1,
                'title' => 'Planning a Healthier Weekly Meal Plan',
                'content' => 'Research healthy and easy-to-cook meals for breakfast, lunch, and dinner. Create a shopping list and prepare a schedule that balances nutrition, affordability, and preparation time. Consider meal prepping for convenience.',
            ],
            [
                'user_id' => 1,
                'title' => 'Reviewing Feedback From the Design Team',
                'content' => 'Go through detailed feedback from the UI/UX team on the latest build. Identify areas needing revision, prioritize tasks, and communicate timelines clearly to ensure alignment with project goals.',
            ],
            [
                'user_id' => 1,
                'title' => 'Exploring New Ideas for Side Projects',
                'content' => 'Spend time brainstorming potential side project ideas that align with current skills and interests. Evaluate their feasibility, required tools, time commitment, and possible benefits for professional growth.',
            ],
            [
                'user_id' => 1,
                'title' => 'Setting Up Monthly Goals and KPIs',
                'content' => 'Define clear and measurable goals for the upcoming month, breaking them down into weekly tasks. Assign KPIs to each major objective and plan weekly reviews to track progress and stay on course.',
            ],
            [
                'user_id' => 1,
                'title' => 'Practicing Mindfulness and Mental Clarity',
                'content' => 'Dedicate a full hour to mindfulness exercises such as meditation, breathing techniques, or journaling. Reflect on emotional triggers and how to respond more calmly and consciously during high-stress situations.',
            ],
            [
                'user_id' => 1,
                'title' => 'Analyzing Analytics from the Latest Campaign',
                'content' => 'Log into analytics dashboards and review key metrics from the latest email and social media campaigns. Document performance insights, identify strengths, and note areas that could be improved in future campaigns.',
            ],
        ];
        

        foreach ($posts as $post) {
            Post::create($post);
        }
    }
}