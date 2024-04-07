<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Redirect;
use App\Models\RedirectLog;
use Hashids\Hashids;
use Carbon\Carbon;

class RedirectController extends Controller
{
    public function show(Request $request, $code)
    {
        $hashids = new Hashids();
        $id = $hashids->decode($code);

        if (empty($id)) {
            abort(404);
        }

        $redirect = Redirect::findOrFail($id[0]);
        $targetUrl = $redirect->url;
        $requestQueryParams = $request->query();

        if (!empty($redirect->query_params)) {
            $redirectQueryParams = json_decode($redirect->query_params, true);
            $mergedQueryParams = array_merge($redirectQueryParams, $requestQueryParams);
        } else {
            $mergedQueryParams = $requestQueryParams;
        }

        $filteredQueryParams = array_filter($mergedQueryParams, function ($value) {
            return !empty($value);
        });

        $targetUrlWithQueryParams = $targetUrl . '?' . http_build_query($filteredQueryParams);

        RedirectLog::create([
            'redirect_id' => $redirect->id,
            'ip' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'referer' => $request->header('Referer'),
            'query_params' => json_encode($filteredQueryParams),
            'accessed_at' => now(),
        ]);

        $redirect->last_access = now()->timestamp;
        $redirect->save();

        return redirect()->to($targetUrlWithQueryParams);
    }

    public function index()
    {
        $redirects = Redirect::whereNull('deleted_at')->get();
        return view('redirects', ['redirects' => $redirects]);
    }

    public function stats($code)
    {
        $hashids = new Hashids();
        $id = $hashids->decode($code);
        $redirect = Redirect::findOrFail($id);

        $totalAccesses = RedirectLog::where('redirect_id', $id)->count();
        $uniqueAccesses = RedirectLog::where('redirect_id', $id)->distinct('ip')->count('ip');

        $topReferrers = RedirectLog::where('redirect_id', $id)
            ->select('referer', \DB::raw('count(*) as count'))
            ->groupBy('referer')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        $accessesLast10Days = RedirectLog::where('redirect_id', $id)
            ->where('accessed_at', '>=', now()->subDays(10)->startOfDay())
            ->select(\DB::raw('DATE(accessed_at) as date'), \DB::raw('count(*) as total'), \DB::raw('count(distinct ip) as unique_count'))
            ->groupBy(\DB::raw('DATE(accessed_at)'))
            ->get();

        $stats = [
            'redirect' => $redirect,
            'totalAccesses' => $totalAccesses,
            'uniqueAccesses' => $uniqueAccesses,
            'topReferrers' => $topReferrers,
            'accessesLast10Days' => $accessesLast10Days,
        ];

        return view('stats', compact('stats'));
    }

    public function edit($code)
    {
        $hashids = new Hashids();
        $id = $hashids->decode($code)[0];
        $redirect = Redirect::findOrFail($id);

        return view('edit', compact('redirect', 'code'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'url' => 'required|url',
        ]);

        $redirect = Redirect::findOrFail($id);

        $redirect->update([
            'url' => $request->url,
            'date_update' => Carbon::now()->timestamp,
        ]);

        return redirect()->route('home')->with('success', 'Redirect atualizado com sucesso!');
    }

    public function logs($code)
    {
        $hashids = new Hashids();
        $id = $hashids->decode($code);

        if (!empty($id) && is_array($id) && count($id) > 0) {
            $redirectLogs = RedirectLog::where('redirect_id', $id[0])->get();
            return view('logs', ['redirectLogs' => $redirectLogs]);
        } else {
            return redirect()->route('home')->with('error', 'Código inválido!');
        }
    }

    public function destroy($id)
    {
        $redirect = Redirect::findOrFail($id);
        $redirect->delete();

        return redirect()->route('redirects.index')->with('success', 'Redirect desativado com sucesso.');
    }
}
