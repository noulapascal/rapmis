<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\Students;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use App\Entity\Distinction;
use App\Entity\Lacunes;
use Symfony\Component\Mime\Address;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Entity\Facteurs_disciplinaires;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
    /**
    * @Route("mail")
    * @Security("is_granted('IS_AUTHENTICATED_FULLY')") //$this->getUser()
    */    
class MailController extends AbstractController
{
  
    
    /**
     * @Route("/distinction_mail/{id?}/{student?}",name ="distinction_mail")
     */
    public function distinctionMail(Distinction $distinction, Students $student, MailerInterface $mailer) {
        

if (!empty($distinction)){
   // print_r($distinction);
  //  var_dump($distinction);
}
$email = (new TemplatedEmail())
    ->from('rapmis@habitechsolution.com')
    ->to(new Address('pascalraiso@gmail.com'),$this->getResponsable($student))
   
    ->subject('Thanks for signing up!')

    // path of the Twig template to render
    ->htmlTemplate('mail/distinction.html.twig')

    // pass variables (name => value) to the template
    ->context([
         'student'=>$student,
                'distinction'=> $distinction ? $distinction: null
             ])
;
$mailer->send($email);


return $this->render('mail/distinction.html.twig',[
                'student'=>$student,
                'name'=> $distinction ? get_class($distinction): null,
                'distinction'=> $distinction ? $distinction: null
            ]);
    }
    
    
    /**
     * @Route("/discipline_mail/{id?}/{student?}",name ="discipline_mail")
     */
    public function disciplineMail(Facteurs_disciplinaires $discipline, Students $student, MailerInterface $mailer) {
        

if (!empty($discipline)){
   // print_r($discipline);
  //  var_dump($discipline);
}
$email = (new TemplatedEmail())
    ->from('rapmis@habitechsolution.com')
    ->to(new Address('pascalraiso@gmail.com'),$this->getResponsable($student))
   
    ->subject('Thanks for signing up!')

    // path of the Twig template to render
    ->htmlTemplate('mail/discipline.html.twig')

    // pass variables (name => value) to the template
    ->context([
         'student'=>$student,
                'discipline'=> $discipline ? $discipline: null
             ])
;
$mailer->send($email);



return $this->render('mail/discipline.html.twig',[
                'student'=>$student,
                'name'=> $discipline ? get_class($discipline): null,
                'discipline'=> $discipline ? $discipline: null
            ]);
    }
    
    /**
     * @Route("/envoi/{name}/{student}",name ="mail_send")
     */
    public function envoiMail($name, Students $student, MailerInterface $mailer) {
        
$proprietes = ['distinction','lacunes','notes','conseil de classe','discipline'];


  
        $email = (new Email())
            ->from('hello@example.com')
            ->to('you@example.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $mailer->send($email);
            return $this->redirectToRoute('students_show', array('id' => $student->getId()));

    }
    public function getResponsable(Students $stud) {
        if(!empty($stud->getEmailResponsable())){
        return $stud->getEmailResponsable ();
    }
 elseif(!empty($stud->getEmailPere())){
     return $stud->getEmailPere();
}
elseif(!empty ($stud->getEmailMere())){
    return $stud->getEmailMere();
}
else {
    return 'test@habitechsolution.com';
}   
}
}
