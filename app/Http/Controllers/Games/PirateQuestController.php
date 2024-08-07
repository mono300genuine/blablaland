<?php

namespace App\Http\Controllers\Games;

use App\Enums\PowerSpecial;
use App\Enums\SkinSpecial;
use App\Http\Controllers\Controller;
use App\Models\Power;
use App\Models\Skin;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class PirateQuestController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index(): Factory|View|Application
    {
        $user   = Auth::user();
        $items  = collect([]);

        $items->add(Skin::whereHidden(0)->whereSpecial(SkinSpecial::PirateQuest)->orderBy('token')->get());
        $items->add(Power::whereHidden(0)->whereSpecial(PowerSpecial::PirateQuest)->orderBy('token')->get());

        $playerFlags    = Power::findOrFail(234)->players();
        $lastFlags      = $playerFlags->get()->reverse()->take(6);
        $flags          = $playerFlags->paginate(30);

        return view('games.pirate-quest', compact('user','items', 'flags', 'lastFlags'));
    }
}
