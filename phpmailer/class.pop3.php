<?php
/*~ class.pop3.php
.---------------------------------------------------------------------------.
|  Software: PHPMailer - PHP email class                                    |
|   Version: 2.0.4                                                          |
|   Contact: via sourceforge.net support pages (also www.codeworxtech.com)  |
|      Info: http://phpmailer.sourceforge.net                               |
|   Support: http://sourceforge.net/projects/phpmailer/                     |
| ------------------------------------------------------------------------- |
|    Author: Andy Prevost (project admininistrator)                         |
|    Author: Brent R. Matzelle (original founder)                           |
| Copyright (c) 2004-2007, Andy Prevost. All Rights Reserved.               |
| Copyright (c) 2001-2003, Brent R. Matzelle                                |
| ------------------------------------------------------------------------- |
|   License: Distributed under the Lesser General Public License (LGPL)     |
|            http://www.gnu.org/copyleft/lesser.html                        |
| This program is distributed in the hope that it will be useful - WITHOUT  |
| ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or     |
| FITNESS FOR A PARTICULAR PURPOSE.                                         |
| ------------------------------------------------------------------------- |
| We offer a number of paid services (www.codeworxtech.com):                |
| - Web Hosting on highly optimized fast and secure servers                 |
| - Technology Consulting                                                   |
| - Oursourcing (highly qualified programmers and graphic designers)        |
'---------------------------------------------------------------------------'

/**
 * POP Before SMTP Authentication Class
 *
 * Author: Richard Davey (rich@corephp.co.uk)
 * License: LGPL, see PHPMailer License
 *
 * Specifically for PHPMailer to allow POP before SMTP authentication.
 * Does not yet work with APOP - if you have an APOP account, contact me
 * and we can test changes to this script.
 *
 * This class is based on the structure of the SMTP class by Chris Ryan
 *
 * This class is rfc 1939 compliant and implements all the commands
 * required for POP3 connection, authentication and disconnection.
 *
 * @package PHPMailer
 * @author Richard Davey
 */

class POP3
{
  /**
   * Default POP3 port
   * @var int
   */
  var $POP3_PORT = 110;

  /**
   * Default Timeout
   * @var int
   */
  var $POP3_TIMEOUT = 30;

  /**
   * POP3 Carriage Return + Line Feed
   * @var string
   */
  var $CRLF = "\r\n";

  /**
   * Displaying Debug warnings? (0 = now, 1+ = yes)
   * @var int
   */
  var $do_debug = 2;

  /**
   * POP3 Mail Server
   * @var string
   */
  var $host;

  /**
   * POP3 Port
   * @var int
   */
  var $port;

  /**
   * POP3 Timeout Value
   * @var int
   */
  var $tval;

  /**
   * POP3 Username
   * @var string
   */
  var $username;

  /**
   * POP3 Password
   * @var string
   */
  var $password;

  /**#@+
   * @access private
   */
  var $pop_conn;
  var $connected;
  var $error;     //  Error log array
  /**#@-*/

  /**
   * Constructor, sets the initial values
   *
   * @return POP3
   */
  function POP3 ()
    {
      $this->pop_conn = 0;
      $this->connected = false;
      $this->error = null;
    }

  /**
   * Combination of public events - connect, login, disconnect
   *
   * @param string $host
   * @param integer $port
   * @param integer $tval
   * @param string $username
   * @param string $password
   */
  function Authorise ($host, $port = false, $tval = false, $username, $password, $debug_level = 0)
  {
    $this->host = $host;

    //  If no port value is passed, retrieve it
    if ($port == false)
    {
      $this->port = $this->POP3_PORT;
    }
    else
    {
      $this->port = $port;
    }

    //  If no port value is passed, retrieve it
    if ($tval == false)
    {
      $this->tval = $this->POP3_TIMEOUT;
    }
    else
    {
      $this->tval = $tval;
    }

    $this->do_debug = $debug_level;
    $this->username = $username;
    $this->password = $password;

    //  Refresh the error log
      $this->error = null;

      //  Connect
    $result = $this->Connect($this->host, $this->port, $th