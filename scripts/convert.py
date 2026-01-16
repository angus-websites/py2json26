import sys
import json
import ast

raw = sys.argv[1]

try:
    formatted_dict = ast.literal_eval(raw)
except Exception as e:
    print("ERROR_INVALID_LITERAL: Could not parse Python literal")
    sys.exit(2)

try:
    json_dict = json.dumps(formatted_dict, indent=4)
except TypeError as e:
    # Example: tuple keys → "keys must be str, int, float, bool or None"
    print("ERROR_JSON_CONVERSION: " + str(e))
    sys.exit(3)
except Exception as e:
    print("ERROR_UNKNOWN_JSON: " + str(e))
    sys.exit(4)

print(json_dict)
