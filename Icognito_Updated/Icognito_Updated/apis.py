# from flask import Flask, request, jsonify
# from flask_cors import CORS
# from dotenv import load_dotenv
# import boto3
# from langchain_aws import BedrockLLM as Bedrock
# from langchain_community.embeddings import BedrockEmbeddings
# from langchain.text_splitter import RecursiveCharacterTextSplitter
# from langchain_community.document_loaders import PyPDFDirectoryLoader
# from langchain_community.vectorstores import FAISS
# from langchain.prompts import PromptTemplate
# from langchain.chains import RetrievalQA
# from langchain.memory import ConversationBufferMemory
# from worker import onboard_business,makepickel
# import json
# import os
# from urllib.parse import urljoin, urlparse
# import asyncio
 
# app = Flask(__name__)
# CORS(app)
# load_dotenv()
 
# session = boto3.Session(region_name='us-east-1')
 

# # Initialize Bedrock client and embeddings
# bedrock = boto3.client(service_name='bedrock-runtime',
#                         region_name='us-east-1')
# bedrock_embeddings = BedrockEmbeddings(model_id="amazon.titan-embed-text-v2:0", client=bedrock)
  
# def get_llama_2_llm():
#     llm = Bedrock(model_id='meta.llama3-70b-instruct-v1:0', client=bedrock, model_kwargs={'max_gen_len': 1024})
#     return llm
 
# prompt_template = """
#     Objective:

#     You are tasked with answering user queries by retrieving the most relevant information from a given website. Make sure your responses are clear, accurate, and based on the retrieved content. You should ensure the context is well understood and summarized in a concise manner.
 
#     Instructions:
 
#         Website Context Extraction:
#             First, extract the key topics, relevant sections, and any structured data (such as titles, headings, bullet points, etc.) from the given website.
 
#             User Query Understanding:
#             Break down the user's question into components and identify the key information that needs to be addressed. Ensure you have a clear understanding of the user's intent.
 
#             Information Retrieval:
#             Retrieve relevant sections of the website that directly address the query. If no direct match is found, provide the most related content that could help answer the query.
 
#             Answer Generation:
#             Based on the retrieved content, generate an informative, contextually relevant response. Ensure your answer is factual and clearly references the website's information.
 
#             Clarifications (Optional):
#             If necessary, ask the user for clarification on ambiguous queries to improve retrieval accuracy.
# Context for Assistant: <context> {context}
# </context>
# Question: {question}
 
# """
# PROMPT = PromptTemplate(template=prompt_template, input_variables=['context', 'question'])
# def get_response_llm(llm, vectorstore_faiss, query, memory):
#     context = memory.buffer
#     retriever = vectorstore_faiss.as_retriever(search_type='similarity', search_kwargs={"k": 3})
#     qa = RetrievalQA.from_chain_type(llm=llm, retriever=retriever, chain_type_kwargs={"prompt": PROMPT})
#     answer = qa.invoke({"query": query})
#     return answer["result"]
 
# @app.route('/ask', methods=['POST'])
# def ask_question():
#     id_param = 'tools_acc_org'
#     #request.args.get('id')
#     faissname = "faiss_index_"+id_param
#     print(faissname)
#     user_question = request.json.get("question")
#     if not user_question:
#         return jsonify({"error": "No question provided"}), 400
 
#     faiss_index = FAISS.load_local(faissname, bedrock_embeddings, allow_dangerous_deserialization=True)
#     llm = get_llama_2_llm()
 
#     # Initialize or use existing memory
#     if "memory" not in app.config:
#         # Limiting the chat memory to 20 exchanges
#         app.config["memory"] = ConversationBufferMemory(max_conversations=20)
 
#     memory = app.config["memory"]
#     answer = get_response_llm(llm, faiss_index, user_question, memory)
#     answer = answer.replace("Assistant<|end_header_id|>\n\n", "")
#     answer = answer.replace("Answer:", "")
    
#     memory.save_context({"user": user_question}, {"assistant": answer})
 
#     response_data = {
#         "user": user_question,
#         "assistant": answer
#     }
    
#     return jsonify(response_data)
 
# # @app.route('/submit_business', methods=['POST'])
# # def process_endpoint():
# #     # Get JSON data from the request
# #     data = request.get_json()
    
# #     # Extract parameters
# #     param1 = data.get('name')
# #     param2 = data.get('website')
# #     param3 = data.get('descp')
    
# #      # Create a dictionary to save
# #     config_data = {
# #         'name': param1,
# #         'website': param2
# #     }
    
# #     # Save to conf.json
# #     dname = urlparse(param2).netloc.replace("www.", "")
# #     dname = dname.replace(".","_")
# #     conf_name = "conf_"+dname+".json"
# #     with open(conf_name, 'w') as json_file:
# #         json.dump(config_data, json_file, indent=4)
# #     # Call the function from worker.py
# #     result = onboard_business(param1, param2,param3)
    
# #     # Return the result as a JSON response
# #     return jsonify({'result': result})

# @app.route('/submit_business', methods=['POST'])
# def process_endpoint():
#     # Get JSON data from the request
#     data = request.get_json()
    
#     # Extract parameters
#     param1 = data.get('name')
#     param2 = data.get('website')
#     param3 = data.get('descp')
    
#     # Generate business ID (convert website to FAISS-friendly format)
#     dname = urlparse(param2).netloc.replace("www.", "").replace(".", "_")

#     # Create a dictionary to save
#     config_data = {
#         'name': param1,
#         'website': param2
#     }
    
#     # Save to conf.json
#     conf_name = f"conf_{dname}.json"
#     with open(conf_name, 'w') as json_file:
#         json.dump(config_data, json_file, indent=4)

#     # Call function from worker.py (if needed)
#     #result = onboard_business(param1, param2, param3)
#     result = asyncio.run(onboard_business(param1, param2, param3))

#     # Construct the chatbot `ask` URL dynamically
#     ask_url = f"http://localhost:5001/ask?id={dname}"
    
#     # Return the result and chatbot query URL
#     return jsonify({
#         'result': result,
#         'ask_url': ask_url
#     })


# @app.route('/skipscrapping', methods=['POST'])
# def skipprocess_endpoint():
#     # Get JSON data from the request
#     data = request.get_json()
    
#     param1 = data.get('website')
    
#     # Call the function from worker.py
#     result = makepickel(param1)
    
#     # Return the result as a JSON response
#     return jsonify({'result': result})


# @app.route('/config', methods=['GET'])
# def get_config():
#     # Check if conf.json exists
#     id_param = request.args.get('id')
#     conf_name = "conf_"+id_param+".json"
#     if os.path.exists(conf_name):
#         with open(conf_name, 'r') as json_file:
#             config_data = json.load(json_file)
#         return jsonify(config_data), 200
#     else:
#         return jsonify({'error': 'Configuration file not found.'}), 404

# if __name__ == '__main__':
#     app.run(host='0.0.0.0', port=5001)
#
#====================Swagger and Expectional Handling Code========================


import asyncio
from flask import Flask, request, jsonify
from flask_cors import CORS
from dotenv import load_dotenv
from flask_restx import Api, Resource, fields
from flask_swagger_ui import get_swaggerui_blueprint
import boto3
from langchain_aws import BedrockLLM as Bedrock
from langchain_community.embeddings import BedrockEmbeddings
from langchain.text_splitter import RecursiveCharacterTextSplitter
from langchain_community.document_loaders import PyPDFDirectoryLoader
from langchain_community.vectorstores import FAISS
from langchain.prompts import PromptTemplate
from langchain.chains import RetrievalQA
from langchain.memory import ConversationBufferMemory
from worker import onboard_business,makepickel
from docx.opc.exceptions import PackageNotFoundError
from werkzeug.exceptions import BadRequest, InternalServerError
import json
import os
from urllib.parse import urljoin, urlparse
import logging 

logging.basicConfig(
    level=logging.INFO,
    format='%(asctime)s - %(levelname)s - %(message)s',
    handlers=[
        logging.FileHandler("main.log"),    # Log to a file
        logging.StreamHandler()                    # Also log to console
    ]
)

logger = logging.getLogger(__name__)
 
app = Flask(__name__)
CORS(app)
load_dotenv()
api = Api(app, version='1.0', title='My API', description='A simple API', doc='/swagger/')
session = boto3.Session(region_name='us-east-1')
 
# Initialize Bedrock client and embeddings
bedrock = boto3.client(service_name='bedrock-runtime',
                        region_name='us-east-1')
bedrock_embeddings = BedrockEmbeddings(model_id="amazon.titan-embed-text-v2:0", client=bedrock)
  
def get_llama_2_llm():
    llm = Bedrock(model_id='meta.llama3-70b-instruct-v1:0', client=bedrock, model_kwargs={'max_gen_len': 1024})
    return llm
 # Define the input models using Flask-RESTX's api.model()

ask_model = api.model('AskModel', {
    'question': fields.String(required=True, description='The question from the user')
})

submit_business_model = api.model('SubmitBusinessModel', {
    'name': fields.String(required=True, description='The business name'),
    'website': fields.String(required=True, description='The business website URL'),
    'descp': fields.String(required=True, description='A description of the business')
})

skipscrapping_model = api.model('SkipScrappingModel', {
    'website': fields.String(required=True, description='The website URL to skip scraping')
})

prompt_template = """
    Objective:

    You are tasked with answering user queries by retrieving the most relevant information from a given website. Make sure your responses are clear, accurate, and based on the retrieved content. You should ensure the context is well understood and summarized in a concise manner.
 
    Instructions:
 
        Website Context Extraction:
            First, extract the key topics, relevant sections, and any structured data (such as titles, headings, bullet points, etc.) from the given website.
 
            User Query Understanding:
            Break down the user's question into components and identify the key information that needs to be addressed. Ensure you have a clear understanding of the user's intent.
 
            Information Retrieval:
            Retrieve relevant sections of the website that directly address the query. If no direct match is found, provide the most related content that could help answer the query.
 
            Answer Generation:
            Based on the retrieved content, generate an informative, contextually relevant response. Ensure your answer is factual and clearly references the website's information.
 
            Clarifications (Optional):
            If necessary, ask the user for clarification on ambiguous queries to improve retrieval accuracy.
Context for Assistant: <context> {context}
</context>
Question: {question}
 
"""
PROMPT = PromptTemplate(template=prompt_template, input_variables=['context', 'question'])
def get_response_llm(llm, vectorstore_faiss, query, memory):
    logger.info("Generating response from LLM...")
    context = memory.buffer
    retriever = vectorstore_faiss.as_retriever(search_type='similarity', search_kwargs={"k": 3})
    qa = RetrievalQA.from_chain_type(llm=llm, retriever=retriever, chain_type_kwargs={"prompt": PROMPT})
    answer = qa.invoke({"query": query})
    logger.info("Response generated successfully.")
    return answer["result"]

@api.route('/ask')
class AskQuestion(Resource):
    @api.expect(ask_model)
    def post(self):
        try:
            id_param = request.args.get('id')
            if not id_param:
                logger.warning("Missing required query parameter: 'id'")
                raise BadRequest("Missing required query parameter: 'id'")

            faissname = f"faiss_index_{id_param}"
            logger.info(f"Using FAISS index: {faissname}")

            user_question = request.json.get("question")
            if not user_question:
                logger.warning("No question provided in the request body.")
                raise BadRequest("No question provided in the request body")

            try:
                faiss_index = FAISS.load_local(
                    faissname, bedrock_embeddings, allow_dangerous_deserialization=True
                )
                logger.info(f"Successfully loaded FAISS index: {faissname}")
            except Exception as e:
                logger.error(f"Failed to load FAISS index '{faissname}': {str(e)}")
                raise InternalServerError(f"Failed to load FAISS index '{faissname}': {str(e)}")

            try:
                llm = get_llama_2_llm()
                logger.info("LLM initialized successfully.")
            except Exception as e:
                logger.error(f"Failed to initialize LLM: {str(e)}")
                raise InternalServerError(f"Failed to initialize LLM: {str(e)}")

            if "memory" not in app.config:
                logger.info("Initializing new conversation memory.")
                app.config["memory"] = ConversationBufferMemory(max_conversations=20)

            memory = app.config["memory"]

            try:
                answer = get_response_llm(llm, faiss_index, user_question, memory)
                answer = answer.replace("Assistant<|end_header_id|>\n\n", "").replace("Answer:", "")
                memory.save_context({"user": user_question}, {"assistant": answer})
                logger.info("Answer generated and saved to memory.")
            except Exception as e:
                logger.error(f"Error generating or saving response: {str(e)}")
                raise InternalServerError(f"Error generating or saving response: {str(e)}")

            response_data = {
                "user": user_question,
                "assistant": answer
            }

            logger.info(f"Response successfully sent for question: {user_question}")
            return jsonify(response_data)

        except BadRequest as e:
            logger.warning(f"BadRequest: {str(e)}")
            return jsonify({"error": str(e)}), 400
        except InternalServerError as e:
            logger.error(f"InternalServerError: {str(e)}")
            return jsonify({"error": str(e)}), 500
        except Exception as e:
            logger.exception(f"Unexpected error occurred: {str(e)}")
            return jsonify({"error": f"Unexpected error: {str(e)}"}), 500

        
# @app.route('/submit_business', methods=['POST'])
# def process_endpoint():
#     # Get JSON data from the request
#     data = request.get_json()
    
#     # Extract parameters
#     param1 = data.get('name')
#     param2 = data.get('website')
#     param3 = data.get('descp')
    
#      # Create a dictionary to save
#     config_data = {
#         'name': param1,
#         'website': param2
#     }
    
#     # Save to conf.json
#     dname = urlparse(param2).netloc.replace("www.", "")
#     dname = dname.replace(".","_")
#     conf_name = "conf_"+dname+".json"
#     with open(conf_name, 'w') as json_file:
#         json.dump(config_data, json_file, indent=4)
#     # Call the function from worker.py
#     result = onboard_business(param1, param2,param3)
    
#     # Return the result as a JSON response
#     return jsonify({'result': result})

@api.route('/submit_business')
class SubmitBusiness(Resource):
    @api.expect(submit_business_model)
    def post(self):
        try:
            logger.info("POST /submit endpoint hit.")

            # Parse request JSON
            try:
                data = request.get_json(force=True)
                logger.info("Request JSON parsed successfully.")
            except BadRequest:
                logger.warning("Invalid or missing JSON body.")
                return {"error": "Invalid or missing JSON body"}, 400

            # Extract parameters
            param1 = data.get('name')
            param2 = data.get('website')
            param3 = data.get('descp')

            logger.info(f"Received data - name: {param1}, website: {param2}, descp: {bool(param3)}")

            # Validate parameters
            if not all([param1, param2, param3]):
                logger.warning("Missing one or more required fields.")
                return {"error": "Missing one or more required fields: 'name', 'website', 'descp'"}, 400

            dname = urlparse(param2).netloc.replace("www.", "").replace(".", "_")
            conf_name = f"conf_{dname}.json"

            config_data = {
                'name': param1,
                'website': param2
            }

            # Save config
            try:
                with open(conf_name, 'w') as json_file:
                    json.dump(config_data, json_file, indent=4)
                logger.info(f"Configuration saved to {conf_name}.")
            except Exception as e:
                logger.error(f"Failed to write config file: {str(e)}")
                return {"error": f"Failed to write config file: {str(e)}"}, 500

            # Run async onboarding
            try:
                logger.info(f"Starting async onboarding for {param1} ({param2})")
                result = asyncio.run(onboard_business(param1, param2, param3))
                logger.info("Onboarding completed successfully.")
            except PackageNotFoundError as e:
                logger.error(f"DOCX file not found or unreadable: {str(e)}")
                return {"error": f"DOCX file not found or unreadable: {str(e)}"}, 400
            except Exception as e:
                logger.exception(f"Unexpected error during onboarding: {str(e)}")
                return {"error": f"Error during onboarding: {str(e)}"}, 500

            ask_url = f"http://localhost:5001/ask?id={dname}"
            logger.info(f"Ask URL generated: {ask_url}")

            return jsonify({
                'result': result,
                'ask_url': ask_url
            })

        except Exception as e:
            logger.exception(f"Unexpected server error: {str(e)}")
            return {"error": f"Unexpected server error: {str(e)}"}, 500
        
@api.route('/skipscrapping')
class SkipScrapping(Resource):
    @api.expect(skipscrapping_model)
    def post(self):
        try:
            logger.info("POST /skipscrapping endpoint called.")

            data = request.get_json()
            if not data:
                logger.warning("No JSON body provided.")
                raise BadRequest("Request must contain a valid JSON body.")

            param1 = data.get('website')
            if not param1:
                logger.warning("Missing 'website' field in request.")
                raise BadRequest("Missing required field: 'website'.")

            try:
                logger.info(f"Calling makepickel for website: {param1}")
                result = makepickel(param1)
                logger.info("makepickel executed successfully.")
            except Exception as e:
                logger.error(f"makepickel failed: {str(e)}")
                raise InternalServerError(f"Failed to process website data: {str(e)}")

            return jsonify({'result': result})

        except BadRequest as e:
            logger.warning(f"BadRequest: {str(e)}")
            return jsonify({'error': str(e)}), 400
        except InternalServerError as e:
            logger.error(f"InternalServerError: {str(e)}")
            return jsonify({'error': str(e)}), 500
        except Exception as e:
            logger.exception(f"Unexpected error: {str(e)}")
            return jsonify({'error': f"Unexpected error: {str(e)}"}), 500

@api.route('/config')
class Config(Resource):
    def get(self):
        try:
            logger.info("GET /config endpoint called.")

            id_param = request.args.get('id')
            if not id_param:
                logger.warning("Missing 'id' query parameter.")
                raise BadRequest("Missing required query parameter: 'id'.")

            conf_name = f"conf_{id_param}.json"
            if not os.path.exists(conf_name):
                logger.warning(f"Config file not found: {conf_name}")
                return jsonify({'error': f"Configuration file '{conf_name}' not found."}), 404

            try:
                logger.info(f"Loading config file: {conf_name}")
                with open(conf_name, 'r') as json_file:
                    config_data = json.load(json_file)
                logger.info("Config loaded successfully.")
            except Exception as e:
                logger.error(f"Failed to read or parse config: {str(e)}")
                raise InternalServerError(f"Error reading or parsing the config file: {str(e)}")

            return jsonify(config_data), 200

        except BadRequest as e:
            logger.warning(f"BadRequest: {str(e)}")
            return jsonify({'error': str(e)}), 400
        except InternalServerError as e:
            logger.error(f"InternalServerError: {str(e)}")
            return jsonify({'error': str(e)}), 500
        except Exception as e:
            logger.exception(f"Unexpected error: {str(e)}")
            return jsonify({'error': f"Unexpected error: {str(e)}"}), 500

# Set up Swagger UI
SWAGGER_URL = '/swagger'  # Swagger UI route
API_URL = '/swagger.json'  # Location of Swagger spec file
swagger_ui_blueprint = get_swaggerui_blueprint(SWAGGER_URL, API_URL, config={'app_name': "My API"})
app.register_blueprint(swagger_ui_blueprint, url_prefix=SWAGGER_URL)

# Generate Swagger JSON endpoint
@app.route('/swagger.json')
def swagger_spec():
    return api.__schema__


if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5001)