<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Account\UpdateRequest;
use App\Interfaces\Repositories\CurrencyRepositoryInterface;
use App\Service\Account\AccountService;
use App\Service\Account\Dto\UpdateDto;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class AccountController extends Controller
{
    public function __construct(
        private readonly CurrencyRepositoryInterface $currencyRepository,
        private readonly AccountService $accountService,
    ) {
    }

    public function show(Request $request): View
    {
        return view('account.account', [
            'user' => $request->user(),
            'currencies' => $this->currencyRepository->getAll(),
        ]);
    }

    public function update(UpdateRequest $request): RedirectResponse
    {
        $this->accountService->update($request->user(), UpdateDto::fromArray($request->validated()));

        return redirect()->route('account')->with('success', 'Successfully.');
    }
}
