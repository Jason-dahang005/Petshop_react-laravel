import React from 'react'
import TextField from '@mui/material/TextField';

const Register = () => {
  return (
    <>
      <TextField id="outlined-basic" size='small' label="First Name" variant="outlined" />
      <TextField id="filled-basic" label="Filled" variant="filled" />
      <TextField id="standard-basic" size='small' label="Standard" variant="standard" />
    </>
  )
}

export default Register
