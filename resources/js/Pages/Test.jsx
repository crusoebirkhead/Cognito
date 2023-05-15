import CognitoForm from '@tylermenezes/cognitoforms-react';


const Test = ({formId, accountId, prefillData}) => (


  <h1>
    <CognitoForm
      formId={formId}
      accountId={accountId}
      prefill={prefillData}
      css="* { }"
    />
  </h1>
);

export default Test