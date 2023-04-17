<?php

namespace App\Jobs;

use App\Models\check_que;
use App\Models\session;
use App\Models\sessionpratikum;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Queue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessChangeQrCode implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id, $qrCode, $type;



    public function __construct($id, $qrCode, $type)
    {
        $this->id = $id;
        $this->qrCode = $qrCode;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $qrCode = Str::random(20);
        check_que::where('QrCode', $this->qrCode)->delete();
        if ($this->type == 'praktikum') {
            $session = sessionpratikum::findOrFail($this->id);
        } else {

            $session = session::findOrFail($this->id);
        }
        $session->update([
            'QrCode' => $qrCode,
        ]);
    }
}
