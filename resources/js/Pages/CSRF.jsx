import React, { useEffect } from 'react';

const CsrfTokenLogger = () => {
  useEffect(() => {
    const fetchCsrfToken = async () => {
      const response = await fetch('/csrf-token'); // Replace with the actual URL/route to fetch the CSRF token
      const data = await response.json();
      console.log(data.csrfToken);
    };

    fetchCsrfToken();
  }, []);

  return null;
};

export default CsrfTokenLogger;