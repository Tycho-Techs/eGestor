# This sample script calls the Power BI API to programmatically monitor the progress of a deployment operation.

# For documentation, please see:
# https://docs.microsoft.com/rest/api/power-bi/pipelines/getpipelineoperation

# Instructions:
# 1. Install PowerShell (https://msdn.microsoft.com/en-us/powershell/scripting/setup/installing-windows-powershell) 
#    and the Power BI PowerShell cmdlets (Install-Module MicrosoftPowerBIMgmt)
#    https://docs.microsoft.com/en-us/powershell/power-bi/overview?view=powerbi-ps
# 2. Run PowerShell as an administrator
# 3. Fill in the parameters below
# 4. Change PowerShell directory to where this script is saved
# 5. > ./DeploymentPipelines-WaitForDeployment.ps1

# Parameters - fill these in before running the script!
# =====================================================

$pipelineName = " FILL ME IN "      # The name of the pipeline
$operationId = " FILL ME IN "       # The operation id - can be obtained from the output of deploy scripts

# End Parameters =======================================

# Login to the Power BI service
Connect-PowerBIServiceAccount | Out-Null

try { 
    # Get pipelines
    $pipelines = (Invoke-PowerBIRestMethod -Url "pipelines"  -Method Get | ConvertFrom-Json).value

    # Try to find the pipeline by display name
    $pipeline = $pipelines | Where-Object {$_.DisplayName -eq $pipelineName}

    if(!$pipeline) {
        Write-Host "A pipeline with the requested name was not found"
        return
    }

    # Get the deployment operation details
    $url =  "pipelines/{0}/Operations/{1}" -f $pipeline.Id,$operationId
    $operation = Invoke-PowerBIRestMethod -Url $url -Method Get | ConvertFrom-Json    

    while($operation.Status -eq "NotStarted" -or $operation.Status -eq "Executing")
    {
        # Sleep for 5 seconds
        Start-Sleep -s 5

        $operation = Invoke-PowerBIRestMethod -Url $url -Method Get | ConvertFrom-Json
    }

    "Deployment completed with status: {0}" -f $operation.Status
} catch {
    $errmsg = Resolve-PowerBIError -Last
    $errmsg.Message
}