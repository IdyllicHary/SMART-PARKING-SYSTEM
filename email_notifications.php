<?php
use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';

function sendEmail($type, $data) {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'hillarymalova1@gmail.com';
    $mail->Password = 'qisy avsq rlxl buin';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->SMTPDebug = 2; 
    $mail->Debugoutput = 'error_log'; 

    $mail->setFrom('no-reply@smartparking.com', 'Smart Parking System');
    $mail->addReplyTo('no-reply@smartparking.com', 'Smart Parking System');
    $mail->addAddress($data['email']);
    $mail->isHTML(true);

    switch($type) {
        case 'registration':
            $mail->Subject = 'Welcome to Smart Parking System - Your Account is Ready';
            $mail->Body = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
                    <div style='background-color: #3498db; padding: 20px; text-align: center;'>
                        <h1 style='color: white;'>Welcome to Smart Parking</h1>
                    </div>
                    
                    <div style='padding: 20px; background-color: #ffffff;'>
                        <p>Dear {$data['name']},</p>
                        
                        <p>Thank you for joining Smart Parking! We're excited to have you as part of our community.</p>
                        
                        <div style='background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;'>
                            <h3 style='color: #3498db; margin-top: 0;'>Your Account Creation Details Are As Follows</h3>
                            <table style='width: 100%; border-collapse: collapse;'>
                                <tr>
                                    <td style='padding: 8px 0; color: #666;'>Full Name</td>
                                    <td style='padding: 8px 0;'>{$data['name']}</td>
                                </tr>
                                <tr>
                                    <td style='padding: 8px 0; color: #666;'>Email Address</td>
                                    <td style='padding: 8px 0;'>{$data['email']}</td>
                                </tr>
                                <tr>
                                    <td style='padding: 8px 0; color: #666;'>Phone Number</td>
                                    <td style='padding: 8px 0;'>{$data['phone']}</td>
                                </tr>
                                <tr>
                                    <td style='padding: 8px 0; color: #666;'>ID Number</td>
                                    <td style='padding: 8px 0;'>{$data['id_number']}</td>
                                </tr>
                                <tr>
                                    <td style='padding: 8px 0; color: #666;'>Vehicle Type</td>
                                    <td style='padding: 8px 0;'>{$data['vehicle_type']}</td>
                                </tr>
                                <tr>
                                    <td style='padding: 8px 0; color: #666;'>Vehicle Registration</td>
                                    <td style='padding: 8px 0;'>{$data['vehicle_reg']}</td>
                                </tr>
                            </table>
                        </div>
                        
                        <div style='background-color: #e8f4fc; padding: 20px; border-radius: 8px; margin: 20px 0;'>
                            <h3 style='color: #3498db; margin-top: 0;'>What You Can Do With Your Account</h3>
                            <div style='display: grid; grid-template-columns: 1fr;'>
                                <div style='padding: 10px; margin: 5px 0; background: white; border-radius: 5px;'>
                                    <i class='fas fa-calendar-check' style='color: #3498db;'></i>
                                    <span style='margin-left: 10px;'>Book parking slots in advance</span>
                                </div>
                                <div style='padding: 10px; margin: 5px 0; background: white; border-radius: 5px;'>
                                    <i class='fas fa-tasks' style='color: #3498db;'></i>
                                    <span style='margin-left: 10px;'>Manage your bookings</span>
                                </div>
                                <div style='padding: 10px; margin: 5px 0; background: white; border-radius: 5px;'>
                                    <i class='fas fa-history' style='color: #3498db;'></i>
                                    <span style='margin-left: 10px;'>View parking history</span>
                                </div>
                                <div style='padding: 10px; margin: 5px 0; background: white; border-radius: 5px;'>
                                    <i class='fas fa-star' style='color: #3498db;'></i>
                                    <span style='margin-left: 10px;'>Access exclusive parking features</span>
                                </div>
                            </div>
                        </div>
                        
                        <p>To get started, simply log in to your account using your registered email and password.</p>
                        
                        <div style='text-align: center; margin-top: 30px;'>
                            <a href='http://localhost/Smart_Parking/user_login.php' style='background-color: #3498db; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px;'>Login Now</a>
                        </div>
                        
                        <p style='margin-top: 30px;'>If you have any questions or need assistance, our support team is here to help.</p>
                        
                        <p>Best regards,<br>The Smart Parking Team</p>
                    </div>
                    
                    <div style='background-color: #f8f9fa; padding: 15px; text-align: center; font-size: 12px;'>
                        <p>This is an automated message, please do not reply to this email.</p>
                        <p>© " . date('Y') . " Smart Parking. All rights reserved.</p>
                    </div>
                </div>
                ";

            break;

            case 'booking':
                $mail->Subject = 'Smart Parking System - Booking Confirmation';
                $mail->Body = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;'>
                    <div style='text-align: center; margin-bottom: 30px;'>
                        <h2 style='color: #3498db; margin-bottom: 0;'>Booking Confirmation</h2>
                        <p style='color: #666; margin-top: 5px;'>Reference ID: #{$data['booking_id']}</p>
                    </div>
            
                    <p>Dear {$data['name']},</p>
                    
                    <p>Thank you for choosing Smart Parking System. Your parking reservation has been successfully confirmed.</p>
            
                    <div style='background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 25px 0;'>
                        <h3 style='color: #2c3e50; margin-top: 0;'>Booking Details</h3>
                        <table style='width: 100%; border-collapse: collapse;'>
                            <tr>
                                <td style='padding: 8px 0; color: #666;'>Parking Slot</td>
                                <td style='padding: 8px 0; font-weight: bold;'>#{$data['slot_number']}</td>
                            </tr>
                            <tr>
                                <td style='padding: 8px 0; color: #666;'>Start Time</td>
                                <td style='padding: 8px 0; font-weight: bold;'>{$data['start_time']}</td>
                            </tr>
                            <tr>
                                <td style='padding: 8px 0; color: #666;'>End Time</td>
                                <td style='padding: 8px 0; font-weight: bold;'>{$data['end_time']}</td>
                            </tr>
                            <tr>
                                <td style='padding: 8px 0; color: #666;'>Duration</td>
                                <td style='padding: 8px 0; font-weight: bold;'>{$data['duration']} Hours</td>
                            </tr>
                            <tr>
                                <td style='padding: 8px 0; color: #666;'>Amount</td>
                                <td style='padding: 8px 0; font-weight: bold;'>KES {$data['price']}</td>
                            </tr>
                        </table>
                    </div>
            
                    <div style='background: #fff3cd; padding: 15px; border-radius: 8px; margin: 20px 0;'>
                        <p style='color: #856404; margin: 0;'><strong>Important Notice:</strong></p>
                        <ul style='color: #856404; margin: 10px 0;'>
                            <li>Please arrive on time for your booking</li>
                            <li>Additional charges apply for extended parking duration</li>
                            <li>Keep this confirmation email for reference</li>
                        </ul>
                    </div>
            
                    <div style='margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;'>
                        <p style='color: #666; font-size: 14px; margin: 0;'>Best regards,</p>
                        <p style='color: #3498db; font-weight: bold; margin: 5px 0;'>Smart Parking Team</p>
                        <p style='color: #666; font-size: 12px;'>This is an automated message. Please do not reply.</p>
                    </div>
                </div>
                ";
                break;            

            case 'password_reset':
                $mail->Subject = 'Smart Parking System - Password Reset';
                $mail->Body = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
                    <h2 style='color: #3498db; text-align: center;'>Password Reset Request</h2>
                    <p>Dear {$data['email']},</p>
                    <p>We received a request to reset your password for your Smart Parking account.</p>
                    <div style='text-align: center; margin: 30px 0;'>
                        <a href='{$data['reset_link']}' 
                           style='background-color: #3498db; 
                                  color: white; 
                                  padding: 15px 30px; 
                                  text-decoration: none; 
                                  border-radius: 5px;
                                  font-weight: bold;
                                  display: inline-block;'>
                            Reset Password
                        </a>
                    </div>
                    <p>For security reasons:</p>
                    <ul>
                        <li>This reset link will expire in 1 hour</li>
                        <li>Can only be used once</li>
                        <li>If you did not request this reset, please contact support immediately</li>
                    </ul>
                    <p>If you're having trouble clicking the button, copy and paste this URL into your browser:</p>
                    <p style='background: #f5f5f5; padding: 10px; font-size: 12px;'>{$data['reset_link']}</p>
                    <hr style='border: 1px solid #eee; margin: 20px 0;'>
                    <p style='color: #666; font-size: 14px;'>Smart Parking System<br>
                    This is an automated message, please do not reply.</p>
                </div>
                ";
                break;  

                case 'booking_cancelled':
                    $mail->Subject = 'Smart Parking System - Booking Cancellation Confirmation';
                    $mail->Body = "
                    <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;'>
                        <div style='text-align: center; margin-bottom: 30px;'>
                            <h2 style='color: #3498db; margin-bottom: 0;'>Booking Cancellation Confirmation</h2>
                            <p style='color: #666; margin-top: 5px;'>Reference ID: #{$data['booking_id']}</p>
                        </div>
                
                        <p>Dear {$data['name']},</p>
                        
                        <p>This email confirms that your parking reservation has been successfully cancelled as per your request.</p>
                
                        <div style='background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 25px 0;'>
                            <h3 style='color: #2c3e50; margin-top: 0;'>Cancelled Booking Details</h3>
                            <table style='width: 100%; border-collapse: collapse;'>
                                <tr>
                                    <td style='padding: 8px 0; color: #666;'>Booking Reference</td>
                                    <td style='padding: 8px 0; font-weight: bold;'>#{$data['booking_id']}</td>
                                </tr>
                                <tr>
                                    <td style='padding: 8px 0; color: #666;'>Parking Slot</td>
                                    <td style='padding: 8px 0; font-weight: bold;'>#{$data['slot_number']}</td>
                                </tr>
                                <tr>
                                    <td style='padding: 8px 0; color: #666;'>Original Booking Time</td>
                                    <td style='padding: 8px 0; font-weight: bold;'>{$data['start_time']} to {$data['end_time']}</td>
                                </tr>
                                <tr>
                                    <td style='padding: 8px 0; color: #666;'>Cancellation Time</td>
                                    <td style='padding: 8px 0; font-weight: bold;'>" . date('F j, Y \a\t g:i a') . "</td>
                                </tr>
                                <tr>
                                    <td style='padding: 8px 0; color: #666;'>Original Booking Amount</td>
                                    <td style='padding: 8px 0; font-weight: bold;'>KES {$data['amount']}</td>
                                </tr>
                            </table>
                        </div>
                
                        <p>If you did not initiate this cancellation, please contact our support team immediately.</p>
                
                        <div style='margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;'>
                            <p style='color: #666; font-size: 14px; margin: 0;'>Best regards,</p>
                            <p style='color: #3498db; font-weight: bold; margin: 5px 0;'>Smart Parking Team</p>
                            <p style='color: #666; font-size: 12px;'>This is an automated message. Please do not reply.</p>
                        </div>
                    </div>
                    ";
                    break;                           

                    case 'account_deletion':
                        $mail->subject = 'Account Deleted - Smart Parking';
                        $mail->Body = "
                        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
                            <div style='background-color: #3498db; padding: 20px; text-align: center;'>
                                <h1 style='color: white;'>Smart Parking Account Deletion</h1>
                            </div>
                            
                            <div style='padding: 20px; background-color: #ffffff;'>
                                <p>Dear {$data['name']},</p>
                                
                                <p>Your Smart Parking account has been successfully deleted as requested.</p>
                                
                                <p>If you didn't request this deletion, please contact our support team immediately.</p>
                                
                                <p>You're welcome to create a new account anytime if you wish to use our services again.</p>
                                
                                <div style='text-align: center; margin-top: 30px;'>
                                    <a href='http://localhost/Smart_Parking/register.php' 
                                       style='background-color: #3498db; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px;'>
                                       Create New Account
                                    </a>
                                </div>
                                
                                <p style='margin-top: 30px;'>Best regards,<br>The Smart Parking Team</p>
                            </div>
                            
                            <div style='background-color: #f8f9fa; padding: 15px; text-align: center; font-size: 12px;'>
                                <p>© " . date('Y') . " Smart Parking. All rights reserved.</p>
                            </div>
                        </div>";
                        break;
                
    }

    return $mail->send();
}
?>
