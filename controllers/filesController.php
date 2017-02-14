<?php
// 1486980512-ce425674-fb6b-4543-9a69-d582d9006b75-9260416409
error_reporting(E_ALL);
ini_set('display_errors', 1);
class FilesController
{
    private $userID = '1484771902-2b3e68f2-3d75-49ab-9d46-359b28d5571e-5834933380058208201164172619591';

    public function upload( array $file ){

        $fileLocation = $file['tmp_name'];
        $fileType = $file['type'];
        $ext = explode( '/', $fileType );
        $dir = '/uploads/'.date('mY');
        $monthDir = $_SERVER['DOCUMENT_ROOT'].$dir;

        # Check if the accept file type was submitted
        if ( $fileType === 'audio/mpeg' || $fileType === 'audio/mp3' ){

            if ($ext[1] === 'mp3' || $ext[1] === 'mpeg'){
                $ext = '.mp3';
            } else {
                $ext = '.'.strtolower($ext[1]);
            }

            # Check if the file size if not less than
            if ( filesize($fileLocation) < 20000000 ){

                $dir = $dir.'/'.date('d').'/'.time().$ext;

                $newLocation = $monthDir.'/'.date('d').'/'.time().$ext;

                # Check if the folder for the present day has already been created
                if (file_exists($monthDir)){

                    # Check if folder for the current day exist
                    if ( file_exists($monthDir.'/'.date('d') ) ){

                        # Upload file to the server
                        if (move_uploaded_file($fileLocation, $newLocation)){
                            $data_url = 'q.sigconert.com'.$dir;
                        }

                    } else {

                        if ( mkdir( $monthDir.'/'.date('d'), 0777 ) ){

                            # Upload file to the server
                            if (move_uploaded_file($fileLocation, $newLocation)){
                                $data_url = 'q.sigconert.com'.$dir;
                            }

                        } else {
                            return 'Present day directory could not be created!';
                        }
                    }

                } else {

                    # Create a folder for the present day
                    if ( mkdir($monthDir, 0777) ){

                        # Upload file to the server
                        if (move_uploaded_file($fileLocation, $newLocation)){
                            $data_url = 'q.sigconert.com'.$dir;
                        }

                    } else {

                        return false;
                    }
                }

                $request = [
                    'action' => 'index_content',
                    'data_url' => $data_url
                ];

                return [ true, $this->deepGram( $request ), $data_url ];

            } else {

                return 'file size limit exceeded!';
            }

        } else {

            return 'file format is not allowed!'.$fileType;
        }

    }

    public function logo( array $file ){

        $fileLocation = $file['tmp_name'];
        $fileType = $file['type'];
        $ext = explode( '/', $fileType );
        $dir = '/img/';
        $monthDir = $_SERVER['DOCUMENT_ROOT'].$dir;

        # Check if the accept file type was submitted
        if ( $fileType === 'image/jpeg' || $fileType === 'image/jpg' || $fileType === 'image/png' ){

            $ext = '.'.strtolower($ext[1]);

            # Check if the file size if not less than
            if ( filesize($fileLocation) < 20000000 ){

                $dir = $dir.time().$ext;

                $newLocation = $monthDir.time().$ext;

                # Upload file to the server
                if (move_uploaded_file($fileLocation, $newLocation)){
                    $data_url = 'q.sigconert.com'.$dir;
                }

                return [ true, $data_url ];

            } else {

                return 'file size limit exceeded!';
            }

        } else {

            return 'file format is not allowed!'.$fileType;
        }

    }

    private function deepGram( array $request ){

        $request['userID'] = $this->userID;
        $payload = json_encode($request);

        $headers = [
            'Content-Type: application/json',
            'Content-Length: '.strlen($payload)
        ];

        $curl = curl_init('api.deepgram.com');
        curl_setopt( $curl, CURLOPT_POST, 1 );
        curl_setopt( $curl, CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $curl, CURLOPT_POSTFIELDS, $payload );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );

        if ( curl_error( $curl ) ){
            return 900;
        } else {
            return curl_exec( $curl );
        }
    }

    public function getObjectStatus( string $contentID ){
        $request = [
            'action' => 'check_object_status',
            'userID' => $this->userID,
            'contentID' => $contentID
        ];

        return $this->deepGram( $request );
    }

    public function search( $query, $contentID ){
        $request = [
            'action' => "object_search",
            'userID' => $this->userID,
            'contentID' => $contentID,
            'query' => $query,
            'filter' => [
                'Pmin' => 0.6
            ]
        ];

        return $this->deepGram($request);
    }
}