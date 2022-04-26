import './App.css';
import { useState } from 'react';
import axios from 'axios';
import Tiptap from './components/Tiptap';

// const BACK_URL = "https://www.omranecom.ma/monasaba/index.php";
const BACK_URL = 'http://courrier.back/backend/src/controllers/CourrierController.php';

function Courrier() {
  const [content, setContent] = useState('');
  const [disabled, setDisabled] = useState(false);
  const [title, setTitle] = useState('')
  const [expediteur, setExpediteur] = useState('')

  // const [title, setTitle] = useState('');
  // const [message, setMessage] = useState('');

  const sendEmail = (e) => {
    // e.preventDefault();
    // var form = document.getElementById('formID');
    // console.log(form);
    var data = {
      title: title,
      message: content,
      expediteur: expediteur
    }
    // console.log(data);
    setDisabled(true)
    // return;
    axios.post(BACK_URL, data)
      .then(function (response) {
        setDisabled(false)
        // console.log(response);
        if (response.data["status"] == true)
          alert("Message envoyé avec succès!")
        else alert("Une erreur est survenue lors de l'envoie du message1!!!!");
      })
      .catch(function (error) {
        setDisabled(false);
        console.log(error);
        alert("Une erreur est survenue lors de l'envoie du message2!");
      })

  }

  return (
    <div className="App container">

      {/* <!-- The Modal --> */}
      <div className="modal" id="myModal">
        <div className="modal-dialog" style={{ minWidth: "900px" }}>
          <div className="modal-content">

            {/* <!-- Modal Header --> */}
            <div className="modal-header">
              <h4 className="modal-title">Nouveau message</h4>
              <button type="button" className="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {/* <!-- Modal body --> */}
            <div className="modal-body">

              <div className="mb-2">
                <label className="form-label">Expediteur:</label>
                <input type="text" className="form-control" id="expediteur" placeholder="Entrer l'email de l'expediteur" name="expediteur"
                  onChange={(e) => { setExpediteur(e.target.value) }} />
              </div>
              <div className="mb-2 mt-2">
                <label className="form-label">Objet:</label>
                <input type="text" className="form-control" id="title" placeholder="Entrer un titre de message" name="title"
                  onChange={(e) => { setTitle(e.target.value) }} />
              </div>
              <div >
                <label className="form-label">Message:</label>
                <Tiptap setContent={setContent} />
              </div>

            </div>

            {/* <!-- Modal footer --> */}
            <div className="modal-footer">
              <button disabled={disabled} type="submit" onClick={sendEmail} className="btn btn-primary mt-2">Diffuser à tout le personnel</button>
            </div>

          </div>
        </div>
      </div>



    </div >
  );
}

export default Courrier;
