<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\PostCategory;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create a default category
        $category = PostCategory::firstOrCreate(
            ['category_name' => 'Article'],
            ['slug' => 'article', 'description' => 'General articles']
        );
        
        // Create articles
        $articles = [
            [
                'title' => 'Revolutionizing the Industry: Mega Hjaya\'s Commitment to Quality',
                'slug' => 'revolutionizing-the-industry-mega-hjayas-commitment-to-quality',
                'content' => '<p class="lead">Mega Hjaya has long been synonymous with excellence in product distribution. Our unwavering dedication to quality is not just a slogan; it\'s the cornerstone of our operations. From meticulous sourcing to rigorous quality control, we ensure that every product we deliver meets the highest standards. This commitment has earned us the trust of countless businesses and consumers alike.</p><h2>Our Quality Assurance Process</h2><p>Our quality assurance process is a multi-faceted approach that begins with selecting reputable suppliers who share our values. We conduct thorough audits and inspections at every stage, from manufacturing to packaging and shipping. Our team of experts utilizes cutting-edge technology and industry best practices to identify and address any potential issues. This proactive approach minimizes risks and ensures that our products consistently meet or exceed expectations.</p><h2>The Impact of Quality</h2><p>The benefits of our commitment to quality are far-reaching. Our customers enjoy greater satisfaction, reduced downtime, and increased productivity. For businesses, this translates to enhanced brand reputation, stronger customer loyalty, and improved bottom lines. At Mega Hjaya, we believe that quality is not just a feature; it\'s an investment in long-term success.</p>',
                'featured_image' => 'https://picsum.photos/seed/article1/800/600.jpg',
                'author_id' => 1,
                'published_date' => '2024-01-15',
                'tags' => 'quality, industry, Mega Hjaya',
            ],
            [
                'title' => 'The Future of Distribution',
                'slug' => 'the-future-of-distribution',
                'content' => '<p class="lead">The distribution industry is undergoing a significant transformation, driven by technological advancements and changing consumer expectations. Mega Hjaya is at the forefront of this evolution, embracing innovation to deliver better services to our clients.</p><h2>Emerging Technologies</h2><p>From AI-powered logistics to blockchain-based supply chain transparency, new technologies are reshaping how products move from manufacturers to end-users. These innovations are not just improving efficiency but also creating new opportunities for value creation.</p><h2>Sustainability in Distribution</h2><p>Environmental concerns are pushing the industry toward more sustainable practices. At Mega Hjaya, we\'re implementing green logistics solutions that reduce our carbon footprint while maintaining service quality.</p>',
                'featured_image' => 'https://picsum.photos/seed/article2/800/600.jpg',
                'author_id' => 1,
                'published_date' => '2024-01-10',
                'tags' => 'distribution, technology, future',
            ],
            [
                'title' => 'Mega Hjaya Expands',
                'slug' => 'mega-hjaya-expands',
                'content' => '<p class="lead">Mega Hjaya is proud to announce our expansion into new markets, extending our reach to serve more customers across the region. This strategic move represents our commitment to growth and our confidence in the future of the distribution industry.</p><h2>New Market Opportunities</h2><p>Our expansion includes entering three new metropolitan areas, where we\'ll be establishing distribution centers and local teams. This will allow us to provide faster delivery times and more personalized service to clients in these regions.</p><h2>Investment in Infrastructure</h2><p>To support our expansion, we\'re investing significantly in new facilities, technology, and human resources. These investments will enhance our operational capabilities and ensure we can maintain our high service standards as we grow.</p>',
                'featured_image' => 'https://picsum.photos/seed/article3/800/600.jpg',
                'author_id' => 1,
                'published_date' => '2024-01-05',
                'tags' => 'expansion, growth, markets',
            ],
            [
                'title' => 'Success Story',
                'slug' => 'success-story',
                'content' => '<p class="lead">Quality isn\'t just a buzzword at Mega Hjaya—it\'s the foundation of our success. In this case study, we explore how our commitment to quality has driven growth for one of our key clients.</p><h2>The Challenge</h2><p>Our client, a leading healthcare provider, was struggling with inconsistent product quality from their previous distributor, resulting in customer complaints and increased operational costs.</p><h2>Our Solution</h2><p>We implemented a comprehensive quality management system that included rigorous product testing, transparent reporting, and continuous improvement processes. This approach not only resolved the immediate issues but also established a framework for long-term quality assurance.</p><h2>The Results</h2><p>Within six months, our client saw a 75% reduction in product-related complaints and a 30% increase in customer satisfaction scores. These improvements translated to significant cost savings and revenue growth, demonstrating the tangible business value of our quality-focused approach.</p>',
                'featured_image' => 'https://picsum.photos/seed/article4/800/600.jpg',
                'author_id' => 1,
                'published_date' => '2024-01-01',
                'tags' => 'success, quality, case study',
            ],
            [
                'title' => 'Innovation in Supply Chain Management',
                'slug' => 'innovation-in-supply-chain-management',
                'content' => '<p class="lead">Supply chain management is evolving rapidly, and Mega Hjaya is embracing innovative approaches to stay ahead of the curve. Our latest initiatives are transforming how we manage inventory, logistics, and customer relationships.</p><h2>Digital Transformation</h2><p>We\'ve implemented a comprehensive digital platform that provides real-time visibility into our entire supply chain. This technology enables us to make data-driven decisions, optimize routes, and respond quickly to changing market conditions.</p><h2>Collaborative Partnerships</h2><p>We believe that innovation happens through collaboration. That\'s why we\'re working closely with our suppliers, customers, and technology partners to develop new solutions that address the complex challenges of modern supply chain management.</p>',
                'featured_image' => 'https://picsum.photos/seed/article5/800/600.jpg',
                'author_id' => 1,
                'published_date' => '2023-12-20',
                'tags' => 'innovation, supply chain, digital',
            ],
            [
                'title' => 'Customer-Centric Approach: Our Philosophy',
                'slug' => 'customer-centric-approach-our-philosophy',
                'content' => '<p class="lead">At Mega Hjaya, we believe that putting customers at the center of everything we do is not just good business—it\'s the right thing to do. Our customer-centric philosophy guides our decisions, processes, and relationships.</p><h2>Understanding Customer Needs</h2><p>We invest significant time and resources in understanding our customers\' businesses, challenges, and goals. This deep understanding allows us to provide solutions that truly add value, rather than just selling products.</p><h2>Building Lasting Relationships</h2><p>We view our customers as long-term partners, not just transactions. This perspective shapes how we communicate, problem-solve, and grow together. Our customer retention rate is a testament to the strength of these relationships.</p>',
                'featured_image' => 'https://picsum.photos/seed/article6/800/600.jpg',
                'author_id' => 1,
                'published_date' => '2023-12-15',
                'tags' => 'customer-centric, philosophy, relationships',
            ],
            [
                'title' => 'Sustainability Initiatives at Mega Hjaya',
                'slug' => 'sustainability-initiatives-at-mega-hjaya',
                'content' => '<p class="lead">As a responsible corporate citizen, Mega Hjaya is committed to sustainable business practices that minimize our environmental impact while maximizing social value. Our sustainability initiatives span across our operations, partnerships, and community engagement.</p><h2>Green Logistics</h2><p>We\'re implementing eco-friendly transportation solutions, optimizing routes to reduce fuel consumption, and investing in electric vehicles for our delivery fleet. These efforts have already reduced our carbon emissions by 25% over the past two years.</p><h2>Community Engagement</h2><p>We believe in giving back to the communities that support us. Through our corporate social responsibility program, we\'re supporting education initiatives, healthcare access, and environmental conservation projects in the areas where we operate.</p>',
                'featured_image' => 'https://picsum.photos/seed/article7/800/600.jpg',
                'author_id' => 1,
                'published_date' => '2023-12-10',
                'tags' => 'sustainability, environment, community',
            ],
            [
                'title' => 'Digital Transformation Journey',
                'slug' => 'digital-transformation-journey',
                'content' => '<p class="lead">Mega Hjaya\'s digital transformation journey began three years ago with a simple goal: to leverage technology to better serve our customers. Today, that journey has transformed every aspect of our operations.</p><h2>From Analog to Digital</h2><p>We started by digitizing our paper-based processes, creating a unified platform that connects our entire operation. This foundation enabled us to build more sophisticated capabilities, from predictive analytics to automated customer service.</p><h2>The Human Element</h2><p>Technology is only as good as the people who use it. That\'s why we\'ve invested heavily in training our team to work effectively with our new digital tools, ensuring that technology enhances rather than replaces human expertise.</p>',
                'featured_image' => 'https://picsum.photos/seed/article8/800/600.jpg',
                'author_id' => 1,
                'published_date' => '2023-12-05',
                'tags' => 'digital transformation, technology, innovation',
            ],
            [
                'title' => 'Employee Spotlight: Our Team\'s Expertise',
                'slug' => 'employee-spotlight-our-teams-expertise',
                'content' => '<p class="lead">Behind Mega Hjaya\'s success is a team of dedicated professionals with diverse expertise and a shared commitment to excellence. In this article, we spotlight some of the key team members who drive our operations forward.</p><h2>Industry Veterans</h2><p>Many of our team members bring decades of experience in the distribution industry. This deep institutional knowledge helps us navigate complex challenges and identify opportunities that others might miss.</p><h2>Next Generation Talent</h2><p>We\'re also investing in the next generation of talent, bringing in fresh perspectives and new skills that complement our experienced team members. This blend of experience and innovation creates a dynamic work environment that fosters creativity and growth.</p>',
                'featured_image' => 'https://picsum.photos/seed/article9/800/600.jpg',
                'author_id' => 1,
                'published_date' => '2023-11-30',
                'tags' => 'employees, team, expertise',
            ],
            [
                'title' => 'Looking Ahead: Our Vision for 2025',
                'slug' => 'looking-ahead-our-vision-for-2025',
                'content' => '<p class="lead">As we approach 2025, Mega Hjaya is focused on strategic initiatives that will position us for continued growth and success. Our vision is centered on innovation, sustainability, and customer-centricity.</p><h2>Strategic Priorities</h2><p>Our strategic priorities for the coming year include expanding our digital capabilities, entering new markets, and deepening our sustainability commitments. These initiatives are designed to create long-term value for our customers, employees, and stakeholders.</p><h2>A Message from Our CEO</h2><p>"The future of distribution is bright, and Mega Hjaya is poised to lead the way," says our CEO. "By staying true to our core values while embracing innovation, we\'re building a company that will thrive for decades to come."</p>',
                'featured_image' => 'https://picsum.photos/seed/article10/800/600.jpg',
                'author_id' => 1,
                'published_date' => '2023-11-25',
                'tags' => 'vision, 2025, strategy',
            ],
        ];
        
        foreach ($articles as $articleData) {
            Post::firstOrCreate(
                ['slug' => $articleData['slug']],
                array_merge($articleData, ['category_id' => $category->id])
            );
        }
    }
}
