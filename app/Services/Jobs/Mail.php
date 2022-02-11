<?php


namespace App\Services\Jobs;

use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail as MailServer;

class Mail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var array */
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;

    }

    /**
     * @throws Exception
     */
    public function handle(): bool
    {
        try {
            $from = data_get($this->data, 'from');
            $to = data_get($this->data, 'to');
            MailServer::send('email', [], function ($message) use ($from,$to) {
                $message->from($from, 'Blog App');
                $message->subject("Blog App");
                $message->to($to);
            });
        } catch (Exception $exception) {
            return false;
        }

        return true;
    }
}
