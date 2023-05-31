<?php

namespace App\Http\Controllers\Snippets;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Snippet;
use App\Models\Step;
use App\Transformers\Snippets\StepTransformer;

class StepController extends Controller
{
    public function update(Snippet $snippet, Step $step, Request $request)
    {
        $this->authorize('update', $step);

        $step->update($request->only('title', 'body'));
    }

    public function destroy(Snippet $snippet, Step $step)
    {
        $this->authorize('destroy', $step);

        if ($snippet->steps->count() === 1) {
            return response(null, 400);
        }

        $step->delete();
    }

    public function store(Snippet $snippet, Request $request)
    {
        $this->authorize('storeStep', $snippet);

        $step = $snippet->steps()->create(
            array_merge($request->only('title', 'body'), [
                'order' => $this->getOrder($request)
            ])
        );

        return fractal()
            ->item($step)
            ->transformWith(new StepTransformer())
            ->toArray();
    }

    protected function getOrder(Request $request)
    {
        return Step::where('uuid', $request->before)
            ->orWhere('uuid', $request->after)
            ->first()
            ->{($request->before ? 'before' : 'after') . 'Order'}();
    }
}
