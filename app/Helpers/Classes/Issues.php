<?php


namespace App\Helpers\Classes;


use App\Models\Issue;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\Promise\all;

class Issues
{

    /**
     * Get all the issues accessible to user.
     * @return mixed
     */
    public static function getAccessibleByUser(Request $request)
    {
        $filters = [
            'rejected' => $request->rejected ?? false,
            'completed' => $request->completed ?? false,
        ];

        //get unassigned issues
        //get assigned
        $issues = DB::table('issues')
            ->whereNull('completed_at')
            ->where('issues.status', '<>', 6)
            ->join('systems', 'issues.system_id', '=', 'systems.id')
            ->leftJoin('users', 'issues.user_id', '=', 'users.id')
            ->select('issues.*', 'users.name as user_name', 'users.email', 'users.profile_photo_path', 'systems.name as system_name', 'systems.repository_link')
            ->orderBy('status', 'ASC')
            ->orderBy('importance', 'DESC')
            ->orderBy('urgency', 'DESC')
            ->orderBy('type', 'ASC')
            ->oldest();

        //add filters
        if ($filters['rejected']) {
            $issues = $issues->orWhere('issues.status', 6);
        }
        if ($filters['completed']) {
            $issues = $issues->orWhere('issues.status', 5);
        }

//        if ($filters['rejected'] && $filters['completed']) {
//            $issues = $issues->orWhere('issues.status', 5)
//                ->orWhere('issues.status', 6);
//        }


        //finalize
        return self::formatIssues($issues->get());

    }

    /**
     * Formats the issues
     *
     * @param Collection $issues
     * @return mixed
     */
    private static function formatIssues(Collection $issues)
    {
        $allIssues = [];

        if (user()->hasRole('admin')) {
            $allIssues = $issues->toArray();
        } else {
            foreach ($issues as $issue) {
                if ($issue->user_id === user()->id){
                    array_push($allIssues, $issue);
                }
            }

        }

        return $allIssues;

    }

}
