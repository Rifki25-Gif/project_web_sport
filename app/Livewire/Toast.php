<?php

namespace App\Livewire;

use Livewire\Component;

class Toast extends Component
{
    public $message = '';
    public $type = 'success'; // success, error, info, warning
    public $show = false;
    public $timeout = 3000; // milliseconds

    protected $listeners = ['show-toast' => 'showToast'];

    public function showToast($params)
    {
        $this->message = $params['message'] ?? 'Notification';
        $this->type = $params['type'] ?? 'success';
        $this->timeout = $params['timeout'] ?? 3000;
        $this->show = true;
        
        // Auto hide after timeout
        $this->dispatch('toast-timer-start', ['timeout' => $this->timeout]);
    }

    public function dismiss()
    {
        $this->show = false;
    }

    public function render()
    {
        return view('livewire.toast');
    }
}
