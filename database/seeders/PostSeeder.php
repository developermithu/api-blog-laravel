<?php

namespace Database\Seeders;

use App\Enums\PostStatus;
use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'category_id' => 1,
                'title' => 'Next.js 14: The Future of React Framework',
                'excerpt' => 'Explore the groundbreaking features of Next.js 14, including server actions, partial rendering, and the new app router.',
                'is_featured' => true,
            ],
            [
                'category_id' => 1,
                'title' => 'Mastering TailwindCSS 3.0',
                'excerpt' => 'Learn how to build modern UIs with TailwindCSS 3.0, including new color palette, dark mode, and responsive design.',
            ],
            [
                'category_id' => 1,
                'title' => 'Laravel 11: What\'s New',
                'excerpt' => 'Discover the latest features in Laravel 11, including performance improvements, new Folio routing, and more.',
            ],
            [
                'category_id' => 1,
                'title' => 'Vue.js 3 Composition API Deep Dive',
                'excerpt' => 'Master the Composition API in Vue.js 3 with practical examples and best practices.',
            ],
            [
                'category_id' => 2,
                'title' => 'Flutter 3.0: Cross-Platform Excellence',
                'excerpt' => 'Build beautiful native apps for iOS and Android with Flutter 3.0\'s new features.',
            ],
            [
                'category_id' => 2,
                'title' => 'React Native Architecture Patterns',
                'excerpt' => 'Learn scalable architecture patterns for large React Native applications.',
            ],
            [
                'category_id' => 2,
                'title' => 'SwiftUI for iOS Development',
                'excerpt' => 'Modern iOS development using SwiftUI framework and best practices.',
            ],
            [
                'category_id' => 2,
                'title' => 'Kotlin Multiplatform Mobile',
                'excerpt' => 'Share code between iOS and Android using Kotlin Multiplatform Mobile.',
            ],
            [
                'category_id' => 3,
                'title' => 'Docker Container Orchestration',
                'excerpt' => 'Master Docker container orchestration with Kubernetes and Docker Swarm.',
            ],
            [
                'category_id' => 3,
                'title' => 'AWS Lambda and Serverless',
                'excerpt' => 'Build serverless applications using AWS Lambda and API Gateway.',
            ],
            [
                'category_id' => 3,
                'title' => 'GitHub Actions CI/CD Pipeline',
                'excerpt' => 'Automate your development workflow with GitHub Actions.',
            ],
            [
                'category_id' => 3,
                'title' => 'Terraform Infrastructure as Code',
                'excerpt' => 'Manage cloud infrastructure using Terraform and Infrastructure as Code principles.',
            ],
            [
                'category_id' => 4,
                'title' => 'ChatGPT API Integration Guide',
                'excerpt' => 'Learn how to integrate ChatGPT API into your applications effectively.',
            ],
            [
                'category_id' => 4,
                'title' => 'Machine Learning with Python',
                'excerpt' => 'Build practical machine learning models using Python and scikit-learn.',
            ],
            [
                'category_id' => 4,
                'title' => 'Computer Vision with TensorFlow',
                'excerpt' => 'Implement computer vision applications using TensorFlow and OpenCV.',
            ],
            [
                'category_id' => 4,
                'title' => 'Natural Language Processing Basics',
                'excerpt' => 'Introduction to NLP concepts and implementations using modern tools.',
            ],
            [
                'category_id' => 5,
                'title' => 'Rust for System Programming',
                'excerpt' => 'Learn system programming with Rust: memory safety and performance.',
            ],
            [
                'category_id' => 5,
                'title' => 'Go Language Best Practices',
                'excerpt' => 'Master Go programming language patterns and best practices.',
            ],
            [
                'category_id' => 5,
                'title' => 'Python 3.12 Advanced Features',
                'excerpt' => 'Explore advanced features and improvements in Python 3.12.',
            ],
            [
                'category_id' => 5,
                'title' => 'Modern C++ Development',
                'excerpt' => 'Modern C++ development techniques and best practices with C++20.',
            ],
            [
                'category_id' => 5,
                'title' => 'React Native Performance Optimization',
                'excerpt' => 'Optimize your React Native app for better performance and responsiveness.',
                'status' => PostStatus::DRAFT,
            ],
            [
                'category_id' => 1,
                'title' => 'PHP 8.2: New Features and Improvements',
                'excerpt' => 'Learn about the latest features and improvements in PHP 8.2.',
                'status' => PostStatus::DRAFT,
            ],
        ];

        foreach ($posts as $post) {
            Post::create([
                'author_id' => 1, // admin
                'category_id' => $post['category_id'],
                'title' => $post['title'],
                'slug' => Str::slug($post['title']),
                'excerpt' => $post['excerpt'],
                'content' => $this->getPostContent($post['title']),
                'status' => $post['status'] ?? PostStatus::PUBLISHED,
                'is_featured' => $post['is_featured'] ?? false,
            ]);
        }
    }

    private function getPostContent(string $title): string
    {
        return <<<HTML
            <article>
                <h2>{$title}</h2>
                
                <img 
                    src="https://images.unsplash.com/photo-1633356122544-f134324a6cee" 
                    alt="{$title}"
                    class="w-full h-96 object-cover rounded-lg mb-8"
                />
                
                <p>
                    In today's <em>rapidly evolving</em> tech landscape, staying current with the latest developments is <strong>crucial for any developer</strong>. 
                    This comprehensive guide will walk you through everything you need to know about this topic.
                </p>

                <blockquote>
                    <p>"The only way to do great work is to love what you do." - Steve Jobs</p>
                </blockquote>

                <hr class="my-8" />

                <h3>Key Features and Benefits</h3>
                <ul>
                    <li><strong>Enhanced performance</strong> and optimization</li>
                    <li>Improved <em>developer experience</em></li>
                    <li>Better security measures - <a href="https://owasp.org/www-project-top-ten/" target="_blank" rel="noopener">OWASP Top 10</a></li>
                    <li>Seamless integration capabilities</li>
                </ul>

                <img 
                    src="https://images.unsplash.com/photo-1587620962725-abab7fe55159" 
                    alt="Code example"
                    class="w-full h-64 object-cover rounded-lg my-8"
                />

                <hr class="my-8" />

                <h3>Getting Started</h3>
                <p>
                    Before diving into advanced concepts, let's ensure you have all the prerequisites installed and configured properly.
                    This will help you follow along with the examples and implementations discussed later. Check out the 
                    <a href="https://docs.github.com/en/get-started" target="_blank" rel="noopener">GitHub Getting Started Guide</a> 
                    for more information.
                </p>

                <pre><code class="language-bash">
                npm install @latest-version
                # or
                yarn add @latest-version
                </code></pre>

                <h3>Advanced Implementation</h3>
                <p>
                    Let's explore some <em>advanced implementation patterns</em> and best practices that will help you build 
                    <strong>more robust applications</strong>.
                </p>

                <blockquote>
                    <p>"Any fool can write code that a computer can understand. Good programmers write code that humans can understand." - Martin Fowler</p>
                </blockquote>

                <hr class="my-8" />

                <h3>Best Practices</h3>
                <ul>
                    <li>Follow the <a href="https://en.wikipedia.org/wiki/Principle_of_least_privilege" target="_blank" rel="noopener">principle of least privilege</a></li>
                    <li>Implement <strong>proper error handling</strong></li>
                    <li>Write <em>comprehensive tests</em></li>
                    <li>Document your code thoroughly</li>
                </ul>

                <h3>Conclusion</h3>
                <p>
                    By following these guidelines and best practices, you'll be well-equipped to handle <em>modern development challenges</em>
                    and build <strong>better applications</strong>. Remember to keep learning and staying updated with the latest developments in the field.
                </p>

                <p class="text-sm mt-8">
                    Further reading: 
                    <a href="https://developer.mozilla.org/en-US/" target="_blank" rel="noopener">MDN Web Docs</a> | 
                    <a href="https://www.w3.org/TR/web-design-principles/" target="_blank" rel="noopener">W3C Design Principles</a>
                </p>
            </article>
        HTML;
    }
}
