<?php

namespace Modules\Post\Livewire\Frontend;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Modules\Post\Models\Post;

#[Layout('components.layouts.frontend')]
#[Title('Recent Posts')]
class RecentPosts extends Component
{
    public int $limit = 5;

    public function render()
    {
        $limit = $this->limit > 0 ? $this->limit : 5;

        $recentPosts = Post::recentlyPublished()->take($limit)->get();

        return view('post::livewire.frontend.recent-posts', [
            'recentPosts' => $recentPosts,
        ]);
    }
}
