<?php

namespace App\Http\Controllers\API\Subscription;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use App\Course;
use App\Subscription;

class SubscriptionController extends Controller
{


    public function subscribe(Request $request)
    {
        $request->validate([
            'course_id' => 'required|numeric',
        ]);

        $user = $request->user();
        $course_id = $request->course_id;
        $course = Course::where('id', $course_id)->where('display', 1)->first();
        if ($course) {
            $subscription = $user->subscriptions()->where('user_id', $user->id)->where('course_id', $course_id)->where('display', 1)->first();
            if ($subscription) {
                return Response::json([
                    'success' => false,
                    'message' => 'you  already subscribed to this course!',
                    'subscription' => $subscription,
                ], 403);
            }

            $subscription = $request->user()->subscriptions()->create([
                'course_id' => $request->course_id
            ]);

            if ($subscription) {
                return Response::json([
                    'success' => true,
                    'message' => 'you\'ve subscribed to this course successfully!',
                    'subscription' => $subscription,
                ], 200);
            } else {
                return Response::json([
                    'success' => false,
                    'message' => 'something wrong happened!',
                ], 500);
            }
        } else {
            return Response::json([
                'success' => false,
                'message' => 'Course not found !',
            ], 404);
        }
    }

    public function unSubscribe(Request $request)
    {
        $request->validate([
            'subscription_id' => 'required|numeric',
            'course_id' => 'required|numeric',
        ]);

        $user = $request->user();
        $course_id = $request->course_id;
        $subscription = $user->subscriptions()
            ->where('id', $request->subscription_id)
            ->where('user_id', $user->id)
            ->where('course_id', $course_id)
            ->where('verified', 0)
            ->where('display', 1)->first();

        if ($subscription) {
            $subscription->display = 0;
            $subscription->update();
            return Response::json([
                'success' => true,
                'message' => 'you\'ve unsubscribed to this course successfully!',
                'subscription' => $subscription,
            ], 200);
        } else {
            return Response::json([
                'success' => false,
                'message' => 'This operation can\'t be done',
            ], 403);
        }
    }
    public function submitReceipt(Request $request)
    {

        $request->validate([
            'subscription_id' => 'required|numeric',
            'receipt' => 'required|file|image|max:10000',
        ]);

        $subscription = Subscription::where('id', $request->subscription_id)
            ->where('receipt', null)
            ->where('verified', 0)
            ->where('display', 1)
            ->get()
            ->first();

        if ($subscription) {

            $this->uploadReceipt($subscription);
            $subscription->status = 'يتم مراجعة الإيصال';
            $subscription->update();
            return Response::json([
                'success' => true,
                'message' => 'your receipt has been sent successfully!',
                'subscription' => $subscription,
            ], 200);
        } else {
            return Response::json([
                'success' => false,
                'message' => 'subscription not found or your subscription receipt is submitted already.',
            ], 403);
        }
    }

    private function uploadReceipt($subscription)
    {
        if (request()->has('receipt')) {
            $subscription->update(['receipt' => request()->receipt->store('uploads/receipts', 'public')]);
        }
    }



    //admin operations

    public function confirmSubscription(Request $request)
    {
        $request->validate([
            'subscription_id' => 'required|numeric',
        ]);

        $subscription = Subscription::where('id', $request->subscription_id)
            ->where('receipt', '!=', null)
            ->where('verified', 0)
            ->where('display', 1)
            ->get()->first();

        if ($subscription) {
            $subscription->verified = 1;
            $subscription->status = 'تم تأكيد الإشتراك';
            $subscription->update();
            return Response::json([
                'success' => true,
                'message' => 'the subscription has been confirmed successfully!',
                'subscription' => $subscription,
            ], 200);
        } else {
            return Response::json([
                'success' => false,
                'message' => 'subscription not found , receipt not sent or the subscription confirmed already.',
            ], 403);
        }
    }

    public function unConfirmSubscription(Request $request)
    {
        $request->validate([
            'subscription_id' => 'required|numeric',
        ]);

        $subscription = Subscription::where('id', $request->subscription_id)
            ->where('receipt', '!=', null)
            ->where('verified', 1)
            ->where('display', 1)
            ->get()->first();

        if ($subscription) {
            $subscription->verified = 0;
            $subscription->status = 'يتم مراجعة الإيصال';
            $subscription->update();
            return Response::json([
                'success' => true,
                'message' => 'the subscription confirmation has been calncelled successfully!',
                'subscription' => $subscription,
            ], 200);
        } else {
            return Response::json([
                'success' => false,
                'message' => 'subscription not found or the subscription unconfirmed already.',
            ], 403);
        }
    }

    public function removeSubscription(Request $request)
    {
        $request->validate([
            'subscription_id' => 'required|numeric',
        ]);

        $subscription = Subscription::where('id', $request->subscription_id)
            ->where('receipt', '!=', null)
            ->where('verified', 0)
            ->where('display', 1)
            ->get()->first();

        if ($subscription) {
            $subscription->display = 0;
            $subscription->update();
            return Response::json([
                'success' => true,
                'message' => 'the subscription  has been removed successfully!',
                'subscription' => $subscription,
            ], 200);
        } else {
            return Response::json([
                'success' => false,
                'message' => 'subscription can\'t be removed.',
            ], 403);
        }
    }
}
