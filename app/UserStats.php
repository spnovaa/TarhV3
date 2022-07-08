<?php

namespace App;

class UserStats
{
    public $stats = null;

    public function getStats()
    {
        $users = User::get();

        foreach ($users as $user) {
            $userBookStats = $this->getUserBookStats($user);

//            return $userInvoices;
//            $userStat = $user->toArray() +
        }
        return $this->stats;
    }

    private function getUserBookStats(User $user)
    {
        $userInvoices = Safinvoice::where('id', $user->id)->get();
        $booksStats = new Safinvoice();
        foreach ($userInvoices as $userInvoice) {
            foreach ($booksStats as $booksStat) {
                if ($booksStat['barcode'] == $userInvoice->barcode) {
                    $booksStat['count'] += $userInvoice->order_count;
                }
            }
        }
        return false;
    }
}
