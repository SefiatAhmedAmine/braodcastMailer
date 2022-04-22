import './App.css';
import {useState} from 'react';
import axios from 'axios';
import Tiptap from './components/Tiptap';

const BACK_URL = "http://courrier.back";


function App() {
  const [content, setContent] = useState('');
  const [disabled, setDisabled] = useState(false);
  const [title, setTitle] = useState('')
  const [expediteur, setExpediteur] = useState('')

  // const [title, setTitle] = useState('');
  // const [message, setMessage] = useState('');

  const sendEmail = (e) => {
    e.preventDefault();
    setDisabled(true);
    // var form = document.getElementById('formID');
    // console.log(form);
    var data = {
      title: title,
      message: content,
      expediteur: expediteur,
    }
    console.log(data);
    // return;
    axios.post(BACK_URL, data)
      .then(function (response) {
        setDisabled(false)
        // window.location.reload()
        console.log(response);
      })
      .catch(function (error) {
        setDisabled(false);
        // window.location.reload()
        console.log(error);
      })
    
    // window.location.replace("http://alomrane.back");
  }

  return (
    <div className="App container">
      <div className="mb-3 mt-3">
          <label className="form-label">Expediteur:</label>
          <input type="text" className="form-control" id="expediteur" placeholder="Entrer un titre" name="expediteur"
            onChange={(e) => { setExpediteur(e.target.value) }} />
        </div>
        <div className="mb-3 mt-3">
          <label className="form-label">Titre:</label>
          <input type="text" className="form-control" id="title" placeholder="Entrer un titre" name="title"
            onChange={(e) => { setTitle(e.target.value) }} />
        </div>
        <div>
          <label className="form-label">Message:</label>
          <Tiptap setContent={setContent} />
        </div>
        <button disabled={disabled} type="submit" onClick={sendEmail} className="btn btn-primary mt-2">Envoyer</button>

    </div >
  );
}

export default App;
