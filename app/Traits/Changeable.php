<?php

namespace App\Traits;

trait Changeable
{
    /**
     * Change project status to registered
     *
     * @return void
     */
    public function registered()
    {
        $this->status = $this->statuses['registered'];
        $this->save();
    }

    /**
     * Change project status to paid
     */
    public function paid()
    {
        $this->status = $this->statuses['paid'];
        $this->save();
    }

    /**
     * Change project status to cancel
     */
    public function cancel()
    {
        $this->status = $this->statuses['cancel'];
        $this->save();
    }

    /**
     * Change project status to started
     */
    public function delivered()
    {
        $this->status = $this->statuses['delivered'];
        $this->save();
    }

    /**
     * Change project status to delivered
     */
    public function started()
    {
        $this->status = $this->statuses['started'];
        $this->save();
    }

    /**
     * Set project status
     *
     * @param string $statusText
     * @return bool
     */
    public function setStatus($statusText)
    {
        if (!array_key_exists($statusText, $this->statuses)) {
            return false;
        }

        $this->status = $this->statuses[$statusText];
        return $this->save();
    }
}
