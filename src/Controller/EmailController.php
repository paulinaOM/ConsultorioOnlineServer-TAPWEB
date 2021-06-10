<?php


namespace App\Controller;

use App\Entity\MedicalConsultation;
use App\Repository\BillRepository;
use App\Repository\MedicalConsultationRepository;
use App\Repository\PatientRepository;
use App\Repository\PrescriptionRepository;
use App\Repository\TicketRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\UrlHelper;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../vendor/autoload.php';


class EmailController
{
    //constructor
    private $medicalConsultationRepository,$prescriptionRepository, $billRepository, $urlHelper,$ticketRepository,$patientRepository;
    public function __construct(MedicalConsultationRepository $medicalConsultationRepository,PrescriptionRepository $prescriptionRepository, BillRepository $billRepository,UrlHelper $urlHelper, PatientRepository $patientRepository,TicketRepository $ticketRepository){
        $this->medicalConsultationRepository=$medicalConsultationRepository;
        $this->prescriptionRepository=$prescriptionRepository;
        $this->billRepository= $billRepository;
        $this->urlHelper = $urlHelper;
        $this->patientRepository=$patientRepository;
        $this->ticketRepository=$ticketRepository;

    }
    /**
     * @Route("/email/ticket", name="sendTicketEmail", methods={"POST"})
     */
    public function emailTicket(Request $request):JsonResponse
    {
        $mail = new PHPMailer(true);
        $data=json_decode($request->getContent(),true);

        $idPatient=$data['id_patient'];
        $idTicket=$data['id_ticket'];

        if(empty($idPatient)||empty($idTicket)){
            throw  new NotFoundHttpException("Se esperaban parámetros");
        }
        $patient= $this->patientRepository->findOneBy(['id'=>$idPatient]);
        $ticket = $this->ticketRepository->findOneBy(['id'=>$idTicket]);

        if ($ticket){
            try {
                $name = $patient->getName()." ".$patient->getLastname();
                $date = $ticket->getDateSale()->format('Y-m-d');
                $emailAddress = $patient->getEmail();
                $file = $this->urlHelper->getAbsoluteUrl('/tickets/'.$ticket->getFilename());

                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = '17030622@itcelaya.edu.mx';                     // SMTP username
                $mail->Password   = 'fcdr220814dprpepe';                               // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                //Recipients
                $mail->setFrom('17030622@itcelaya.edu.mx', 'Consultorio online');
                $mail->addAddress('17030658@itcelaya.edu.mx', $name);     // Add a recipient

                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Ticket de compra';
                $mail->Body    = '<p>Estimado paciente, '.$name.', su ticket correspondiente a la compra con fecha del '.$date.' ha sido enviado, para descargarlo presione el siguiente enlace: <a href="'.$file.'">Ticket de compra</a></p>';

                $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

        }
        return new JsonResponse(['status'=> 'Email send'], Response::HTTP_OK);
    }

    /**
     * @Route("/email/prescription", name="sendPrescriptionEmail", methods={"POST"})
     */
    public function emailPrescription(Request $request):JsonResponse
    {
        $mail = new PHPMailer(true);
        $data=json_decode($request->getContent(),true);

        $idConsultation=$data['id_consultation'];

        if(empty($idConsultation)){
            throw  new NotFoundHttpException("Se esperaban parámetros");
        }
        $consultation= $this->medicalConsultationRepository->findOneBy(['id'=>$idConsultation]);
        $prescription = $this->prescriptionRepository->findOneBy(['medicalConsultation'=>$idConsultation]);

        if ($consultation){
            try {
                $name = $consultation->getIdPatient()->getName()." ".$consultation->getIdPatient()->getLastname();
                $date = $consultation->getConsultationDate()->format('Y-m-d');
                $emailAddress = $consultation->getIdPatient()->getEmail();
                $file = $this->urlHelper->getAbsoluteUrl('/prescriptions/'.$prescription->getFilename());

                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = '17030622@itcelaya.edu.mx';                     // SMTP username
                $mail->Password   = 'fcdr220814dprpepe';                               // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                //Recipients
                $mail->setFrom('17030622@itcelaya.edu.mx', 'Consultorio online');
                $mail->addAddress('17030658@itcelaya.edu.mx', $name);     // Add a recipient

                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Receta medica';
                $mail->Body    = '<p>Estimado paciente, '.$name.',su receta correspondiente a la cita con fecha del '.$date.' ha sido enviada, para descargarla presione el siguiente enlace: <a href="'.$file.'">Receta</a></p>';

                $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

        }
        return new JsonResponse(['status'=> 'Email send'], Response::HTTP_OK);
    }

    /**
     * @Route("/email/bill", name="sendBillEmail", methods={"POST"})
     */
    public function emailBill(Request $request):JsonResponse
    {
        $mail = new PHPMailer(true);
        $data=json_decode($request->getContent(),true);

        $idConsultation=$data['id_consultation'];

        if(empty($idConsultation)){
            throw  new NotFoundHttpException("Se esperaban parámetros");
        }
        $consultation= $this->medicalConsultationRepository->findOneBy(['id'=>$idConsultation]);
        $bill = $this->billRepository->findOneBy(['medicalConsultation'=>$idConsultation]);

        if ($bill){
            try {
                $name = $consultation->getIdPatient()->getName()." ".$consultation->getIdPatient()->getLastname();
                $date = $consultation->getConsultationDate()->format('Y-m-d');
                $emailAddress = $consultation->getIdPatient()->getEmail();
                $file = $this->urlHelper->getAbsoluteUrl('/bills/'.$bill->getFilename());

                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = '17030622@itcelaya.edu.mx';                     // SMTP username
                $mail->Password   = 'fcdr220814dprpepe';                               // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                //Recipients
                $mail->setFrom('17030622@itcelaya.edu.mx', 'Consultorio online');
                $mail->addAddress('17030658@itcelaya.edu.mx', $name);     // Add a recipient

                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Factura';
                $mail->Body    = '<p>Estimado paciente, '.$name.', su factura correspondiente a la cita con fecha del '.$date.' ha sido enviada, para descargarla presione el siguiente enlace: <a href="'.$file.'">Factura</a></p>';

                $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

        }
        return new JsonResponse(['status'=> 'Email send'], Response::HTTP_OK);
    }

}
