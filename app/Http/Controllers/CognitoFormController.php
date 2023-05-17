<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class CognitoFormController extends Controller
{
    public function load(Request $request)
    {
        $url = $request->input('url');
        $formProps = $this->getFormDetails($url);
        $prefillData = json_decode($request->query('params'));

        return Inertia::render('Test', [
            'formId' => $formProps['formId'],
            'accountId' => $formProps['accountId'],
            'prefillData' => $prefillData,
        ]);
    }

    public function getFormDetails($url)
{
    // Make a GET request to the provided URL
    $response = \Http::get($url);
    
    // Get the body of the response
    $body = $response->body();

    // Create a new DOMDocument instance
    $dom = new \DOMDocument();
   
    // Load the HTML content into the DOMDocument with options
    libxml_use_internal_errors(true);
    $dom->loadHTML($body, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    libxml_clear_errors();

    // Get all script tags within the body
    $scriptTags = $dom->getElementsByTagName('script');
    
    //define formId and accountId
    $formId = '';
    $accountId = '';

    // Iterate through the script tags in reverse order
    foreach ($scriptTags as $script) {
    
        // Retrieve the script content using saveHTML and substring
        $scriptContent = substr($dom->saveHTML($script), strlen('<script'), -strlen('</script>'));
    
        // Check if the script content contains 'data-form' and 'data-key'
        if (strpos($scriptContent, 'data-form') !== false && strpos($scriptContent, 'data-key') !== false) {
            // Extract the formId and accountId from the script content
            preg_match('/data-form="([^"]+)"/', $scriptContent, $formMatches);
            preg_match('/data-key="([^"]+)"/', $scriptContent, $accountMatches);
    
            if (count($formMatches) === 2 && count($accountMatches) === 2) {
                $formId = $formMatches[1];
                $accountId = $accountMatches[1];
                break;
            }
        }
    }

    // Create an array with the extracted form details
    $formDetails = [
        'formId' => $formId,
        'accountId' => $accountId,
    ];

    return $formDetails;
}
}