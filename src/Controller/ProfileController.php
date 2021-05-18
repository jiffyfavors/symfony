<?php
namespace App\Controller;


use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Profile;
use App\Repository\ProfileRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
class ProfileController
{


     private $profileRepo;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepo = $profileRepository;
    }


/**
 * @Route("/profile/add", methods={"POST"})
 */

     public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $fullname = $data['fullname'];
        $mobile = $data['mobile'];
        $email = $data['email'];
        $gender=$data['gender'];
        $birthdate=$data['birthdate'];

        //Start of Server Validation
        $errors = [];
         if (empty($fullname) ){
             $errors[] ='Fullname is required and must not be empty';
         }

          if (empty($mobile) ){
              $errors[] ='Mobile is required and must not be empty';
         }
         if(empty($email))
         $errors[] ='Email is required and must not be empty.';
         if(empty($gender))
           $errors[] ='Gender is required and must not be empty.';
         if(empty($birthdate))
         $errors[] ='Birthdate is required and must not be empty.';


         if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] ='Email is invalid';
}
if(!preg_match("/^(09|\+639)\d{9}$/",$mobile)){
    $errors[] = 'Invalid Philippine Number Format';
}




         //End of Server Validation
        if (sizeof($errors)>0) {
          
              return new JsonResponse(['status' => 'Expecting parameters!','errors'=>$errors], Response::HTTP_BAD_REQUEST);
        }
        else{


 $this->profileRepo->addNewProfile($fullname,$mobile, $email, $gender, $birthdate);

        return new JsonResponse(['status' => 'Profile saved to database'], Response::HTTP_CREATED);

        }

        
    }




/**
 * @Route("/profile/get-all-profile", methods={"GET"})
 */

 public function getAll(): JsonResponse{

     $profiles = $this->profileRepo->findAll();
    $data = [];

    foreach ($profiles as $profile) {
        $data[] = $profile->getProfile();
    }

    return new JsonResponse(array('data'=>$data), Response::HTTP_OK);
 }
}